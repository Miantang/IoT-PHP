[Hg255D对应的packages包](http://downloads.openwrt.org/attitude_adjustment/12.09/ramips/rt305x/packages/)

###编译非官方的ipk

[openwrt SDK, 利用SDK生成自己的ipk安装包](http://blog.chinaunix.net/uid-23780428-id-4367339.html)

此文主要介绍了用SDK生成所需的软件包，以及相关makefile的编写

[使用交叉编译编译在OpenWRT上运行的程序](http://blog.csdn.net/ffilman/article/details/5744942)


###所需openwrt固件

[0226-DreamBox-ramips-rt305x-hg255d-squashfs-sysupgrade.bin](http://download.unxmail.com/openwrt/hg255d/)

###备份设置

        /etc/nginx/fastcgi_params
        /etc/nginx/nginx.conf
        /etc/nginx/vhost.conf
        /etc/my.cnf
   
   overlay : 528931a4-f19e-4de9-8c6d-40d0951e8c2f 
   
   /mnt/sda3 : a91d90d0-54f1-4378-b5df-91ce9b9f2ca9 
   
   swap : b1dafc32-4d49-48c2-848e-928c65066e7e 
----   
   swap : be9eed84-87f6-4ad0-98de-da633e16b97f
   
src/gz chaos_calmer_base http://downloads.openwrt.org/snapshots/trunk/ramips/generic/packages/base
src/gz chaos_calmer_extra http://downloads.openwrt.org/snapshots/trunk/ramips/generic/packages/extra
src/gz chaos_calmer_luci http://downloads.openwrt.org/snapshots/trunk/ramips/generic/packages/luci
src/gz chaos_calmer_management http://downloads.openwrt.org/snapshots/trunk/ramips/generic/packages/management
src/gz chaos_calmer_oldpackages http://downloads.openwrt.org/snapshots/trunk/ramips/generic/packages/oldpackages
src/gz chaos_calmer_packages http://downloads.openwrt.org/snapshots/trunk/ramips/generic/packages/packages
src/gz chaos_calmer_routing http://downloads.openwrt.org/snapshots/trunk/ramips/generic/packages/routing
src/gz chaos_calmer_telephony http://downloads.openwrt.org/snapshots/trunk/ramips/generic/packages/telephony


###编译openwrt

从download 处下载了最新的openwrt 1407 

按照http://www.right.com.cn/forum/forum.php?mod=viewthread&tid=124604

`make menuconfig` 遇到gnu-find 的问题

解决：http://blog.csdn.net/qingfengtsing/article/details/39346403

[编译过程](http://www.right.com.cn/forum/thread-83746-1-1.html)


