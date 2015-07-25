curl -i --request PUT  --data "{\"switch\":1}"  http://127.0.0.1/index.php/switches/1/switch
curl -i --request POST  --data "{\"code\":0}"  http://127.0.0.1/index.php/feedback/led1

curl -i --request POST  --data "{\"type\":\"switch\",\"value\":7}"  http://127.0.0.1/index.php/devices/1

curl -i --request POST  --data "{\"type\":\"step\",\"switch\":7,\"controller\":1}"  http://127.0.0.1/index.php/devices/7


curl -i --request PUT  --data "{\"switch\":1}"  http://192.168.1.1:8080/index.php/switches/1/switch
curl -i --request POST  --data "{\"code\":0}"  http://192.168.1.1:8080/index.php/feedback/led1

curl -i --request POST  --data "{\"type\":\"switch\",\"value\":7}"  http://192.168.1.1:8080/index.php/devices/1

curl -i --request POST  --data "{\"type\":\"step\",\"switch\":7,\"controller\":1}"  http://192.168.1.1:8080/index.php/devices/7


mosquitto_sub -v -t d1 -h 192.168.1.1

mosquitto_pub -t d1 -h 192.168.1.1 -m "{\"type\":\"switch\",\"value\":0}"

curl -i --request POST  --data "{\"type\":\"switch\",\"value\":1}"  http://192.168.1.1:8080/index.php/mqttdevices/1

curl -i --request POST  --data "{\"type\":\"step\",\"switch\":1,\"controller\":12}"  http://192.168.1.1:8080/index.php/mqttdevices/7

