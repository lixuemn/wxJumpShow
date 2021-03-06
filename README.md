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
| 1.下载 | git clone https://github.com/JueMeiAlg/wxJumpShow.git 下载后执行 cd wxJumpShow |
| 2.安装依赖 | composer update 或者 composer install|
| 3.复制出环境配置文件 |php -r "copy('.env.example', '.env')"; |
| 4.配置你的数据库连接信息 | 在项目根目录.env文件中的 DB_DATABASE DB_USERNAME DB_PASSWORD 等字段处填写你的数据库信息 |
| 5.修改.env APP_URL 处信息 | 此处填写你当前配置的网站域名 |
| 6.生成APP_KEY | php artisan key:generate |
| 7.运行数据迁移 | php artisan migrate |
| 8.storage软连接 | php artisan storage:link /
| 9.安装passport | php artisan passport:install|
| 10.给予缓存文件合适的权限 | chmod -R 777 storage  |
| 11.运行程序  | `php bin/laravels {start\stop\restart}` |
| 12.配置Nginx  | 太长看下面 |

#### Nginx配置
```
server
{
    listen 80;
    server_name example.com;
    index index.php index.html index.htm default.php default.htm default.html;
    root /yourRootPath/wxJumpShow/public;
    
    #SSL-START SSL相关配置，请勿删除或修改下一行带注释的404规则
    #error_page 404/404.html;
    #SSL-END
    
    #ERROR-PAGE-START  错误页配置，可以注释、删除或修改
    #error_page 404 /404.html;
    #error_page 502 /502.html;
    #ERROR-PAGE-END
    
    #PHP-INFO-START  PHP引用配置，可以注释或修改
    include enable-php-72.conf;
    #PHP-INFO-END
    
    #REWRITE-START URL重写规则引用,修改后将导致面板设置的伪静态规则失效
    include /www/server/panel/vhost/rewrite/show.e6ty9e.cn.conf;
    #REWRITE-END
    
    #禁止访问的文件或目录
    location ~ ^/(\.user.ini|\.htaccess|\.git|\.svn|\.project|LICENSE|README.md)
    {
        return 404;
    }
    
    #一键申请SSL证书验证目录相关设置
    location ~ \.well-known{
        allow all;
    }
    
    location ~ .*\.(gif|jpg|jpeg|png|bmp|swf)$
    {
        expires      30d;
        error_log off;
        access_log /dev/null;
    }
   location / 
    {
    	try_files $uri @laravels;
    }
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
        proxy_pass http://127.0.0.1:5200;
    }
    
    location ~ .*\.(js|css)?$
    {
        expires      12h;
        error_log off;
        access_log /dev/null; 
    }
    access_log  /www/wwwlogs/show.e6ty9e.cn.log;
    error_log  /www/wwwlogs/show.e6ty9e.cn.error.log;
}
 ```
#### 其他
本代码只负责展示页面数据,他的完整运行需要部署 https://github.com/JueMeiAlg/wxJump 安装访问请访问该页面查看


#### 如果本项目给你带了帮助请 start一下 谢谢
