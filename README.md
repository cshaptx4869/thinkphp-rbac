# Thinkphp5.1实现RBAC

### 简介

基于前后端分离的权限控制，可控制到页面元素。

RBAC原理和实现详见：https://www.cnblogs.com/cshaptx4869/p/12461972.html



## 使用

**后端：**

导入根目录下的 `rabc.sql` 文件，复制 `env-example` 文件为 `.env` 文件，并配置 `database` 项参数。

**前端：**

前端基于 `vue + element-ui` 实现，下载地址：https://github.com/cshaptx4869/vue-cli2-init 的 `dev` 分支。

配置 `src/config/index.js` 文件的 `devServerUrl(开发环境)/prodServerUrl(生产环境)` 接口地址参数。



## 效果

![1215492-20200419135020773-459597964.png](https://i.loli.net/2021/08/07/PDMulj92iqosF1E.png)

