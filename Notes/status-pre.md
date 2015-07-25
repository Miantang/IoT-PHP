###操作集：
  1. 控制器：①发送指令于各个节点。②接收各个节点的指令③遍历各个节点信息（获取状态）
  2. 子节点：①获取来自控制器的指令。②发送本身的状态给控制器。

###数据量：
Switches:
  1. Led1:{name:"led1", switch:0/1}
  2. Curtain:{name:"curtain", switch:0/1}
  3. Screen:{name:"screen", switch:0/1}
  4. Tap_water:{name:"tap_water", switch:0/1}
  5. Projector:{name:"projector", switch:0/1}
  6. Camara:{name:"camara", switch:0/1}

StepDevices:
  6. LED2:{name:"led2", switch:0/1, controller:"up"/"down"/"stay"}
  7. LED3:{name:"led3", switch:0/1, controller:"red"/"green"/"blue"}
  8. Sound:{name:"sound", switch:0/1, controller:"up"/"down"/"stay"}

GenericDevices:
  9. Access Control:{name:"access", timestamp:?, data:?}
  10. Gas:{name:"gas",  timestamp:?, data:?}
  11. TV:{name:"tv", switch, sound_value, channel_value}
  12. Air Conditioner:{name:"conditioner", switch, channel_value}

###API:

#####请求头中尝试设置Content-Type为application/json

  Host : 192.168.1.1
  Port : 8080

####更新设备信息 PUT：
  Switches:
  
    PUT /index.php/switches/{id}/switch
    值：{\"switch\" : [0 or 1]}
  
  StepDevices:
  
    PUT /index.php/stepdevices/{id}/switch
    值：{\"switch\" : [0 or 1]}
    
    PUT /index.php/stepdevices/{id}/controller
    值：{\"controller\" : [0 or + or -]}
    
    PUT /index.php/stepdevices/{id}
    值：{\"switch\" : [0 or 1], \"controller\" : [0 or + or -]}
    
####获取设备信息 GET：

    GET /index.php/switches/{id}/switch
    值：{\"switch\" : [0 or 1]}
    
    GET /index.php/stepdevices/{id}
    值：{\"switch\" : [0 or 1], \"controller\" : [0 or + or -]}

####成功改变状态FeedBack：
    POST /index.php/feedback/{name}
    值： "{\"code\":0}"
