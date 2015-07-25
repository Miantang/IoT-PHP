http://phoboslab.org/log/2013/09/html5-live-video-streaming-via-websockets

http://www.right.com.cn/forum/thread-35868-1-1.html

###openwrt 挂载摄像头
http://www.openwrt.org.cn/bbs/forum.php?mod=viewthread&tid=6105

mjpg_streamer -i "input_uvc.so -y -f 5 -r 320*240 -q 50 -d /dev/video0" -o "output_http.so -p 8081 -w /mnt/sda3/webcam"

摄像头页面。。嵌入一个iframe即可。

`<iframe xmlns="http://www.w3.org/1999/xhtml" align="middle" width="640" height="480" id="videoframe" scrolling="no" border="0" name="lantk" frameBorder="0" src="http://192.168.1.1:8081/javascript_simple.html"></iframe>`
  
