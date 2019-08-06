# 微信跳转防封服务端

### 安装方法

### 安装环境检查及配置

| 步骤  |
| ------|
|  确定mysql版本 >= 5.7 |
|  php版本 >= 7.1 |
|  php扩展安装了 fileinfo 扩展 |
|  移除掉php禁用函数 putenv |
|  移除掉php禁用函数 readlink |
|  移除掉php禁用函数 symlink |
|  移除掉php禁用函数 proc_open |
|  安装了swoole 扩展 没安装运行 `pecl install swoole` 安装 |
|  优化项:建议安装opcache 扩展 |


### 具体安装
| 步骤 | 指令 |
| ------ | ------ |
| 1.下载 | git clone git@github.com:JueMeiAlg/wxJumpShow.git |
| 2.安装依赖 | composer update 或者 composer install|
| 3.复制出环境配置文件 |php -r "copy('.env.example', '.env')"; |
| 4.配置你的数据库连接信息 | 在项目根目录.env文件中的 DB_DATABASE DB_USERNAME DB_PASSWORD 等字段处填写你的数据库信息 |
| 5.修改.env APP_URL 处信息 | 此处填写你当前配置的网站域名 |
| 6.生成APP_KEY | php artisan key:generate |
| 7.运行数据迁移 | php artisan migrate |
| 8.storage软连接 | php artisan storage:link 
| 9.给予缓存文件合适的权限 | chmod -R 777 storage  |
| 10.运行程序  | `php bin/laravels {start\stop\restart}` |
| 11.配置Nginx  | 太长看下面 |

#### Nginx配置
```
gzip on;
 gzip_min_length 1024;
 gzip_comp_level 2;
 gzip_types text/plain text/css text/javascript application/json application/javascript application/x-javascript application/xml application/x-httpd-php image/jpeg image/gif image/png font/ttf font/otf image/svg+xml;
 gzip_vary on;
 gzip_disable "msie6";
 upstream swoole {
     # Connect IP:Port
     server 127.0.0.1:5200 weight=5 max_fails=3 fail_timeout=30s;
     # Connect UnixSocket Stream file, tips: put the socket file in the /dev/shm directory to get better performance
     #server unix:/xxxpath/laravel-s-test/storage/laravels.sock weight=5 max_fails=3 fail_timeout=30s;
     #server 192.168.1.1:5200 weight=3 max_fails=3 fail_timeout=30s;
     #server 192.168.1.2:5200 backup;
     keepalive 16;
 }
 server {
     listen 80;
     # Don't forget to bind the host
     server_name example.com;
     root /examplePath/public;
     access_log /examplePath/log/nginx/$server_name.access.log  main;
     autoindex off;
     index index.html index.htm;
     # Nginx handles the static resources(recommend enabling gzip), LaravelS handles the dynamic resource.
     location / {
         try_files $uri @laravels;
     }
     # Response 404 directly when request the PHP file, to avoid exposing public/*.php
     #location ~* \.php$ {
     #    return 404;
     #}
     location @laravels {
         # proxy_connect_timeout 60s;
         # proxy_send_timeout 60s;
         # proxy_read_timeout 120s;
         proxy_http_version 1.1;
         proxy_set_header Connection "";
         proxy_set_header X-Real-IP $remote_addr;
         proxy_set_header X-Real-PORT $remote_port;
         proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
         proxy_set_header Host $http_host;
         proxy_set_header Scheme $scheme;
         proxy_set_header Server-Protocol $server_protocol;
         proxy_set_header Server-Name $server_name;
         proxy_set_header Server-Addr $server_addr;
         proxy_set_header Server-Port $server_port;
         proxy_pass http://swoole;
     }
 }
 ```
#### 其他
本代码只负责展示页面数据,他的完整运行需要部署 https://github.com/JueMeiAlg/wxJump 安装访问请访问该页面查看


#### 如果本项目给你带了帮助请 start一下 谢谢