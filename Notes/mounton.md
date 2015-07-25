###openwrt挂载u盘，并将系统转移到u盘中

本文采用的是 [HG255D OpenWrt Chaos Calmer r45323固件](http://pan.baidu.com/s/1hqnHl44) 

 [相关介绍文档](http://www.right.com.cn/forum/thread-135772-1-1.html)

####1. 添加U盘支持
自带usb支持，ext4支持。（假如不支持USB热插拔，请自行搜索）如

> [【Openwrt 项目开发笔记】：USB挂载& U盘启动（三）](http://www.cnblogs.com/double-win/p/3841801.html)

>[openwrt挂载u盘，并将系统转移到u盘中 ](http://blog.csdn.net/wonengxing/article/details/24270071)

需要注意的是：此固件基于[barrier_breaker/14.07/ramips/rt305x/](http://downloads.openwrt.org/barrier_breaker/14.07/ramips/rt305x/) *or snapshots/trunk/ramips/rt305x/*

自带的block-mount已经集成了block-extroot。在相关的luci界面下【系统->挂载点】即可设置相关的挂载，无需手动修改/etc/config/fstab文件。

######最好是使用uuid挂载######  查看uuid，采用blkid（opkg install blkid）

####2. U盘分区
- ① 准备工作，添加必要软件

        opkg install kmod-fs-ext3        #添加ext3文件系统支持
        opkg install fdisk               #添加分区工具
        opkg install e2fsprogs           #添加格式化和检测工具
        
- ②U盘分区

    查看U盘情况：
    
        fdisk -l 
    
    对分区进行操作：
    
        fdisk /dev/sda
        
######注意U盘的盘符名称，千万不要看错（sda或者sdb），以免酿成大错 ######

- ③格式化U盘操作：

        mkfs.ext3 /dev/sda1 　　#将第一个分区格式化为ext3格式
        mkswap /dev/sda2    　　#将第二个分区格式化为swap交换分区
        mkfs.ext3 /dev/sda3 　　#将第三个分区格式化为ext3格式
    
####3. 添加U盘启动

        mkdir /tmp/root        　　　　　　 #在/tmp目录下创建一个临时目录，用于放置系统镜像
        mount /dev/sda1 /mnt　　　　　　　　#将/dev/sda1 挂载到/mnt目录下
        mount -o bind / /tmp/root　　　　　#将根目录"/"制作镜像，并将其挂载到“/tmp/root”下
        cp /tmp/root/* /mnt -a　　　　　　　#将/tmp/root/ 目录下的所有内容复制到/mnt下，相当于将/mnt/root下的所有内容复制到/dev/sda1下
        umount /tmp/root    　　　　　　　　#解除挂载 /tmp/root
    
- ①修改分区表：
    
新版的默认不使用fstab需要：
    
        /sbin/block detect > /etc/config/fstab
        
[参考:Open WRT 折腾指南](http://dingjinqiang.me/2013/09/open-wrt-%E6%8A%98%E8%85%BE%E6%8C%87%E5%8D%97/)
    
尝试添加`option target '/overlay'`
    
- ②开机启动：

        root@OpenWrt:/# /etc/init.d/fstab enable 
        root@OpenWrt:/# /etc/init.d/fstab start 
        this file has been obseleted. please call "/sbin/block mount" directly 
        /dev/mtdblock3 is already mounted
        
出现警告无需理会，然后重启路由器。即可发现已经将系统成功挂载到U盘。

####4. 注意事项：

- 重启后，执行df -h后如果发现/overlay挂载在/tmp/overlay-disabled上

解决方案：

    rm /tmp/overlay-disabled/etc/extroot.md5sum
    
    或者删除/tmp/overlay-disabled目录下的所有系统文件，按照第2重新操作重启。
    

