## 项目概述

- 产品名称：「联运科技答题大转盘」
- 项目代码：huishuoit_lianyun
- 官方地址：http://lianyun.mandokg.com

该项目主要是为了针对连云科技的每周六活动所开发的。致力于推动分好啦平台粉丝的增长。

## 运行环境要求

- Nginx 1.8+
- PHP 5.6+
- Mysql 5.7+
- Redis 3.0+
- Memcached 1.4+

## 开发环境部署/安装

本项目代码使用 PHP 框架 [Laravel 5.3](http://laravel-china.org/docs/5.3/) 开发，本地开发环境使用 [Laravel Homestead](http://laravel-china.org/docs/5.3/homestead)。

### 基础安装

#### 1. 克隆源代码

克隆 `phphub` 源代码到本地：

    > git clone https://github.com/syfberryhzy/huishuo_lianyuan.git

#### 2. 配置本地的 Homestead 环境

1). 运行以下命令编辑 Homestead.yaml 文件：

```shell
homestead edit
```

2). 加入对应修改，如下所示：

```shell
folders:
    - map: ~/my-path/lianyun/ # 你本地的项目目录地址
      to: /home/vagrant/lianyun

sites:
    - map: lianyun.app
      to: /home/vagrant/lianyun/public

databases:
    - lianyun
```

3). 应用修改

修改完成后保存，然后执行以下命令应用配置信息修改：

```shell
homestead provision
```

> 注意：有时候你需要重启才能看到应用。运行 `homestead halt` 然后是 `homestead up` 进行重启。

#### 3. 安装扩展包依赖

    > composer install

#### 4. 生成配置文件

```shell
cp .env.example .env
```

你可以根据情况修改 `.env` 文件里的内容，如数据库连接、缓存设置等：

```shell
APP_URL=http://lianyun.app
...
DB_HOST=localhost
DB_DATABASE=lianyun
DB_USERNAME=homestead
DB_PASSWORD=secret
```

#### 5. 生成数据表及生成测试数据

在 Homestead 的网站根目录下运行以下命令

```shell
php artisan migrate --seed
```

#### 6. 创建初始化后台

在 Homestead 的网站根目录下运行以下命令

```shell
php artisan admin:install
```

#### 7. 生成秘钥

```shell
php artisan key:generate
```

#### 8. 配置 hosts 文件

    echo "192.168.10.10   lianyun.app" | sudo tee -a /etc/hosts


### 前端框架安装

1). 安装 node.js

    直接去官网 [https://nodejs.org/en/](https://nodejs.org/en/) 下载安装最新版本。

2). 安装 Gulp

```shell
npm install --global gulp
```

3). 安装 Laravel Elixir

```shell
npm install
```

4). 安装 bower

```shell
npm install --global bower
```

5). 运行 bower 下载前端组件包

```shell
bower install
```

6). 直接 Gulp 编译前端内容

```shell
gulp
```

7). 监控修改并自动编译

```shell
gulp watch
```

### 链接入口

* 首页地址：http://lianyun.app/
* 管理后台：http://lianyun.app/admin

管理员账号密码如下:

```
username: admin
password: estgroupe
```

至此, 安装完成 ^_^.

## 服务器架构说明

![file](https://fsdhubcdn.phphub.org/uploads/images/201705/20/1/1G6aQPAZym.png)

> 上图使用工具 [ProcessOn](https://www.processon.com) 绘制。

## 部署须知

我们使用 [Envoy](https://laravel.com/docs/5.0/envoy) 进行代码部署。

### 1. 安装 envoy

```
composer global require "laravel/envoy=~1.0"
```

> 关于 Envoy 的使用，请查阅 [文档](http://laravel-china.org/docs/5.4/envoy)。

### 2. 命令列表

在你获得服务器访问权限后（请资讯项目负责人），即可在 `本地项目根目录` 执行以下命令进行代码部署：

```
// 仅更新代码
envoy run update

// 更新代码, 并执行 migration
envoy run update-with-migrate

// 更新代码, 并执行 gulp build
envoy run update-with-gulp

// 更新代码, 并执行 composer
envoy run update-with-composer-install
```

## 扩展包使用情况

| 扩展包                                      | 一句话描述                  | 本项目应用场景          |
| ---------------------------------------- | ---------------------- | ---------------- |
| [orangehill/iseed](https://github.com/orangehill/iseed) | 将数据库数据导出为 Seed 文件      | 导出线上数据，方便于本地开发测试 |
| [predis/predis](https://github.com/nrk/predis.git) | Redis 官方首推的 PHP 客户端开发包 | 缓存驱动 Redis 基础扩展包 |
