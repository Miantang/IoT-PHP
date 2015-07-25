###MQTT Learning Note

#### 1. 什么是MQTT

> MQTT（Message Queuing Telemetry Transport，消息队列遥测传输）是IBM开发的一个即时通讯协议，有可能(?)成为物联网的重要组成部分。是面向M2M和物联网的连接协议，采用轻量级发布和订阅消息传输机制。Mosquitto是一款实现了 MQTT v3.1 协议的开源消息代理软件，提供轻量级的，支持发布/订阅的的消息推送模式，使设备对设备之间的短消息通信简单易用。

- 【MQTT协议特点】——相比于RESTful架构的物联网系统，MQTT协议借助消息推送功能，可以更好地实现远程控制。
- 【MQTT协议角色】——在RESTful架构的物联网系统，包含两个角色客户端和服务器端，而在MQTT协议中包括发布者，代理器（服务器）和订阅者。
- 【MQTT协议消息】——MQTT中的消息可理解为发布者和订阅者交换的内容（负载），这些消息包含具体的内容，可以被订阅者使用。
- 【MQTT协议主题】——MQTT中的主题可理解为相同类型或相似类型的消息集合。

####2. linux下使用MQTT

[Mosquitto简要教程（安装/使用/测试）](http://blog.csdn.net/shagoo/article/details/7910598)

[MQTT学习笔记——Yeelink MQTT服务 使用mqtt.js和paho-mqtt ](http://blog.csdn.net/xukai871105/article/details/39346461)


####3. 物联网下MQTT

[MQTT物联网协议相关开发库](http://www.open-open.com/lib/view/open1421134493953.html)
