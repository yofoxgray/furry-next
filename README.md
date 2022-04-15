# FurryNeXT框架

### 框架介绍

这个框架原先是因为觉得 zh.furrywiki.cn 不好看而写的，现将其开源，希望大家一起写新功能一起修bug

## 使用教程

### 搭建

1. 下载到本地
2. 解压到一个文件夹
3. 将网站根目录设置成 public 目录
4. 设置伪静态为

Nginx: 

```
location / {
	if (!-e $request_filename){
		rewrite  ^(.*)$  /index.php?s=$1  last;   break;
	}
}
```

Apache:

```
<IfModule mod_rewrite.c>
  Options +FollowSymlinks -Multiviews
  RewriteEngine On

  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteRule ^(.*)$ index.php/$1 [QSA,PT,L]
</IfModule>
```

### 安装

1. 访问 你的协议头://你的域名:你的端口/app.php/install
2. 填写信息，点击安装
3. 弹窗表示完成后即安装完成

### 更新
1. 访问 你的协议头://你的域名:你的端口/app.php/install/update
2. 显示 “更新完成” 4个字即更新完成