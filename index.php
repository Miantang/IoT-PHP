<?php

require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->get( '/', function () use ($app) 
{
    
    if(!isset($_SESSION))
    {
        session_start();
    }
    if ( !isset($_SESSION['username']) )
    {
        // header('Location:public/index.html'); 
        echo "<script language=\"javascript\">";

        echo "document.location=\"public/index.html\"";

        echo "</script>";
        
    }
    else
    {
        echo "<script language=\"javascript\">";

        echo "document.location=\"public/index.html\"";

        echo "</script>";
    }
    
    # $app->render('phpinfo.php',array('title'=>'PHP'));
});
/***************             Devices                 **********************/
// GET /switches?page=1&rows=10
$app->get('/devices', function () use ($app) 
{ 
    include 'conn.php';

    $sql = "select * from devices ";
    $rs = mysql_query($sql);
    $items = array();

    while($row = mysql_fetch_object($rs))
    {
        $row->description = urlencode($row->description );
        array_push($items, $row);
    }

    $app->response()->header('Content-Type', 'application/json');
    echo json_encode($items, JSON_NUMERIC_CHECK);
});

// GET /devices/:id 
$app->get('/devices/:id', function ($id) use ($app) 
{ 
    include 'conn.php';
    $sql = "select * from devices where id = '$id' limit 1";
    $rs = mysql_query($sql);
    
    if($row = mysql_fetch_object($rs))
    {
        $app->response()->header('Content-Type', 'application/json');

        echo json_encode( $row, JSON_NUMERIC_CHECK);
    } 
    else 
    {
        $app->response()->status(404);
    }
});

// GET /devices/:id/value 
$app->get('/devices/:id/value', function ($id) use ($app) 
{ 
    include 'conn.php';
    //$sql = 'select * from switches where id =' . $id;
    $sql = "select * from devices where id = '$id' limit 1";
    $rs = mysql_query($sql);
    $row = mysql_fetch_object($rs);

    if(null != $row)
    {
        
        if ("switch" == $row->type) 
        {
            $device_value = "{\"switch\":".(string)$row->value."}";
        }
        elseif ("step" == $row->type) 
        {
            $device_value = (string)$row->value;
        }
        
        $app->response()->header('Content-Type', 'application/json');
        echo  json_encode( json_decode($device_value,true), JSON_NUMERIC_CHECK);
    } 
    else 
    {
        $app->response()->status(404);
    }
});

// POST value 
$app->post('/devices/:id', function ($id) use ($app) 
{   
    // the arduino post a string ,then encode it to a json.
    $request = $app->request();
    $body = $request->getBody();
    $input = json_decode($body);   
    $type = (string)$input->type;
    // $type = $_POST["type"];  
    include 'conn.php';
    // classify three types from the json code items.   
    
    if ("switch" == $type)
    {
        // $value = $_POST['value'];
        $value = $input->value;
    }
    elseif ("step" == $type) 
    {
        // $switch = $_POST['switch'];
        // $controller = $_POST['controller'];
        $switch = (string)$input->switch;
        $controller = (string)$input->controller;
        $value = '{"switch":'.$switch.',"controller":'.$controller.'}';     
    }

    $sql = "update devices set value='$value' where id='$id'";

    $result = @mysql_query($sql);
    if ($result)
    {
        //echo (string)$body;
        echo json_encode(array('success'=>true));
    } 
    else 
    {
        echo json_encode(array('success'=>false));
    }
});
/***************             MQTT Devices                **********************/
// POST value publish
$app->post('/mqttdevices/:id', function ($id) use ($app) 
{   
    // the arduino post a string ,then encode it to a json.
    $request = $app->request();
    $body = $request->getBody();
    $input = json_decode($body);   
    $type = (string)$input->type;
      
    include 'conn.php';

     if("switch" == $type)
    {
        $value = $input->value;
        $device_value = "{\"switch\":".(string)$value."}";
        $mqtt_message = json_encode( json_decode($device_value,true), JSON_NUMERIC_CHECK);
    }
    elseif ("step" == $type) 
    {
        $switch = (string)$input->switch;
        $controller = (string)$input->controller;
        $value = '{"switch":'.$switch.',"controller":'.$controller.'}'; 
        $mqtt_message = json_encode( json_decode($value, true), JSON_NUMERIC_CHECK);    
    }

    $sql = "update devices set value='$value' where id='$id'";

    $result = @mysql_query($sql);

    require("public/phpMQTT.php");

    $mqtt = new phpMQTT("127.0.0.1", 1883, "phpMQTT"); //Change client name to something unique

    if ($mqtt->connect()) 
    {
        $mqtt->publish("d".$id, $mqtt_message, 0);
        $mqtt->close();
    }
    
    if ($result)
    {
        echo json_encode(array('success'=>true));
    } 
    else 
    {
        echo json_encode(array('success'=>false));
    }
});
/***************             User                        **********************/
$app->get('/userall', function () use ($app)
{   
    $username = htmlspecialchars($_GET['username']);  
  //  $password = $_POST['pwd'];  
    include 'conn.php';
    if ("admin" === $username) 
    {
        $sql = "select * from userlists";
        $rs = mysql_query($sql);
        $items = array();

        while($row = mysql_fetch_object($rs))
        {
            if ($row->username !== "admin") 
            {
                array_push($items, $row);
            }
        }
    }
    
    $app->response()->header('Content-Type', 'application/json');
    echo json_encode($items);
});

$app->get('/user', function () use ($app)
{   
    $username = htmlspecialchars($_GET['username']);  
  //  $password = $_POST['pwd'];  

    include 'conn.php';
    if ("admin" === $username ) 
    {
        $sql = "select * from userlists where username='$username' limit 1";
        $rs = mysql_query($sql);

        if($result = mysql_fetch_object($rs))
        {
            $app->response()->header('Content-Type', 'application/json');
            echo json_encode($result); 
        }
    }

});

$app->post('/user', function () use ($app)
{   
    $result = false;
    $request = $app->request();
    $body = $request->getBody();
    $input = json_decode($body);   
    $username = (string)$input->username;
    $realname = (string)$input->realname;
    $email = (string)$input->email;  
    $qq = (string)$input->qq;  
  //  $password = $_POST['pwd'];  

    include 'conn.php';
    
    $sql = "update userlists set realname='$realname', email='$email', qq='$qq' where username='$username' limit 1";
    $rs = @mysql_query($sql);

    if($rs)
    {
    }
    
});

$app->post('/userlogin', function () 
{   
    $username = htmlspecialchars($_POST['username']);  
    $password = $_POST['pwd'];  

    include 'conn.php';

    $check_query = mysql_query("select * from userlists where username='$username' and password='$password' limit 1"); 

    if ($result = mysql_fetch_array($check_query))
    {

        echo json_encode(array('username'=>$username)); 
       /* if(!isset($_SESSION))
        {
            session_start();
        }   
        $_SESSION['username'] = $result['username'];  
        $_SESSION['password'] = $result['password']; */
    } 
    else 
    {
        //header('Location:/public/index.html'); 
    }
});

$app->post('/userdelete', function () 
{   
    $username = htmlspecialchars($_POST['username']);  
   //   $password = $_POST['pwd'];  
    $deleteName = $_POST['delname'];  
    include 'conn.php';

    if ("admin" === $username) 
    {
        $sql = "delete from userlists where username='$deleteName' limit 1"; 
        $result = @mysql_query($sql);
    }
});

$app->post('/useredit', function () use ($app) 
{   
    $result = false;
    $request = $app->request();
    $body = $request->getBody();
    $input = json_decode($body);   
    $username = (string)$input->username;
    $oldpwd = (string)$input->oldpwd;
    $newpwd = (string)$input->newpwd;

    include 'conn.php';
    $check_query = mysql_query("select * from userlists where username='$username' and password='$oldpwd' limit 1"); 

    if ($checkresult = mysql_fetch_object($check_query)) 
    {
        $update_sql = "update userlists set password='$newpwd' where username='$username' limit 1";
        $result = @mysql_query($update_sql);
    }
    if ($result)
    {
        echo json_encode(array('password'=>$newpwd)); 
    } 
    else 
    {
    }
});

$app->post('/usercreate', function () use ($app) 
{   
    $result = false;
    $request = $app->request();
    $body = $request->getBody();
    $input = json_decode($body);   
    $username = (string)$input->username;
    $password = (string)$input->password;
    $realname = (string)$input->realname;
    $qq = (string)$input->qq;
    $email = (string)$input->email;
    // $username = $_POST['username'];
    // $oldpwd = $_POST['oldpwd'];
    // $newpwd = $_POST['newpwd'];

    include 'conn.php';
    
    $query = "INSERT INTO userlists(username, password, realname, qq, email) VALUE('$username', '$password', '$realname','$qq', '$email')";  
    $result = @mysql_query($query);
    
    if ($result)
    {
        echo json_encode(array('username'=>$username)); 
    } 
    else 
    {
    }
});
/***************             FeedBack                 **********************/
$app->post('/feedback/:name', function ($name) use ($app) 
{   
    $request = $app->request();
    $body = $request->getBody();
    $input = json_decode($body);  
    
    $feedback = $input->code; 
    $name = (string)$name;

    include 'conn.php';
    // To ensure that there is $name or not
    $sql = "update feedBackCode set code='$feedback' where name='$name'";
    $result = @mysql_query($sql);
    if ($result)
    {
        echo json_encode(array('updatefeedBack'=>true));
    } 
    else 
    {
        echo json_encode(array('updatefeedBack'=>false));
    }
    
});

$app->get('/feedback/:name', function ($name) use ($app) 
{ 
  include 'conn.php';
  //$sql = 'select * from switches where id =' . $id;
  $sql = "select code from feedBackCode where name='$name' limit 1";
  $rs = mysql_query($sql);
  
  if($row = mysql_fetch_object($rs))
    {
        $app->response()->header('Content-Type', 'application/json');

        echo $row->code;//json_encode( $row, JSON_NUMERIC_CHECK);
    } 
    else 
    {
        $app->response()->status(404);
    }
});

$app->run();
