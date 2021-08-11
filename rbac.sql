/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50724
 Source Host           : localhost:3306
 Source Schema         : rbac

 Target Server Type    : MySQL
 Target Server Version : 50724
 File Encoding         : 65001

 Date: 11/08/2021 21:35:16
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for api
-- ----------------------------
DROP TABLE IF EXISTS `api`;
CREATE TABLE `api`  (
  `api_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `api_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '接口名称',
  `api_route` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '接口路由',
  `api_method` enum('post','get','put','delete') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'post' COMMENT '接口请求方法',
  `api_desc` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '接口描述',
  `api_sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` int(11) NOT NULL DEFAULT 0,
  `updated_at` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`api_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 37 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统-接口表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of api
-- ----------------------------
INSERT INTO `api` VALUES (1, '用户列表', 'admin/user/index', 'post', '后端用户列表权限', 100, 1586873702, 1587135151);
INSERT INTO `api` VALUES (2, '添加用户', 'admin/user/store', 'post', '', 100, 1586879802, 1586879802);
INSERT INTO `api` VALUES (3, '更新用户', 'admin/user/update', 'post', '', 100, 1586880199, 1586880209);
INSERT INTO `api` VALUES (5, '角色列表', 'admin/role/index', 'post', '', 120, 1586964214, 1587135126);
INSERT INTO `api` VALUES (6, '用户预加载', 'admin/user/preview', 'post', '', 100, 1587026825, 1587026825);
INSERT INTO `api` VALUES (7, '用户详情', 'admin/user/show', 'post', '', 100, 1587132496, 1587132528);
INSERT INTO `api` VALUES (8, '删除用户', 'admin/user/destroy', 'post', '', 100, 1587135092, 1587135092);
INSERT INTO `api` VALUES (9, '添加角色', 'admin/role/store', 'post', '', 121, 1587215683, 1587215688);
INSERT INTO `api` VALUES (10, '角色预加载', 'admin/role/preview', 'post', '', 122, 1587215707, 1587215707);
INSERT INTO `api` VALUES (11, '角色详情', 'admin/role/show', 'post', '', 122, 1587215733, 1587215733);
INSERT INTO `api` VALUES (12, '更新角色', 'admin/role/update', 'post', '', 124, 1587215752, 1587215752);
INSERT INTO `api` VALUES (13, '删除角色', 'admin/role/destroy', 'post', '', 125, 1587215958, 1587215958);
INSERT INTO `api` VALUES (14, '角色授权预加载', 'admin/role/authorizepreview', 'post', '', 126, 1587215981, 1587286774);
INSERT INTO `api` VALUES (15, '角色授权', 'admin/role/authorize', 'post', '', 127, 1587215997, 1587215997);
INSERT INTO `api` VALUES (16, '接口列表', 'admin/api/index', 'post', '', 130, 1587227192, 1587227210);
INSERT INTO `api` VALUES (17, '接口预加载', 'admin/api/preview', 'post', '', 131, 1587227234, 1587227234);
INSERT INTO `api` VALUES (18, '接口详情', 'admin/api/show', 'post', '', 132, 1587227253, 1587286569);
INSERT INTO `api` VALUES (19, '删除接口', 'admin/api/destroy', 'post', '', 134, 1587227273, 1587227273);
INSERT INTO `api` VALUES (20, '添加接口', 'admin/api/store', 'post', '', 135, 1587227293, 1587227293);
INSERT INTO `api` VALUES (21, '更新接口', 'admin/api/update', 'post', '', 136, 1587227332, 1587227332);
INSERT INTO `api` VALUES (22, '添加元素', 'admin/element/store', 'post', '', 140, 1587227374, 1587227374);
INSERT INTO `api` VALUES (23, '元素列表', 'admin/element/index', 'post', '', 141, 1587227394, 1587227394);
INSERT INTO `api` VALUES (24, '元素预加载', 'admin/element/preview', 'post', '', 142, 1587227414, 1587227414);
INSERT INTO `api` VALUES (25, '更新元素', 'admin/element/update', 'post', '', 143, 1587227433, 1587227433);
INSERT INTO `api` VALUES (26, '元素详情', 'admin/element/show', 'post', '', 144, 1587227450, 1587227450);
INSERT INTO `api` VALUES (27, '删除元素', 'admin/element/destroy', 'post', '', 145, 1587227465, 1587227465);
INSERT INTO `api` VALUES (28, '菜单列表', 'admin/menu/index', 'post', '', 150, 1587227482, 1587227482);
INSERT INTO `api` VALUES (29, '添加菜单', 'admin/menu/store', 'post', '', 152, 1587227499, 1587227499);
INSERT INTO `api` VALUES (30, '菜单预加载', 'admin/menu/preview', 'post', '', 153, 1587227519, 1587227519);
INSERT INTO `api` VALUES (31, '菜单详情', 'admin/menu/show', 'post', '', 155, 1587227537, 1587227537);
INSERT INTO `api` VALUES (32, '更新菜单', 'admin/menu/update', 'post', '', 156, 1587227561, 1587227561);
INSERT INTO `api` VALUES (33, '删除菜单', 'admin/menu/destroy', 'post', '', 158, 1587227582, 1587227582);
INSERT INTO `api` VALUES (34, '菜单状态更新', 'admin/menu/status', 'post', '', 100, 1587230908, 1587230908);
INSERT INTO `api` VALUES (35, '角色状态更新', 'admin/role/status', 'post', '', 100, 1587230979, 1587230979);
INSERT INTO `api` VALUES (36, '用户状态更新', 'admin/user/status', 'post', '', 100, 1587231000, 1587231000);

-- ----------------------------
-- Table structure for element
-- ----------------------------
DROP TABLE IF EXISTS `element`;
CREATE TABLE `element`  (
  `element_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `element_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '资源名',
  `element_type` enum('page','block') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'page' COMMENT '元素类型 page-页面 block-块组件',
  `element_code` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '元素编号(前台路由)',
  `element_desc` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '元素描述',
  `element_sort_order` int(11) NOT NULL DEFAULT 0 COMMENT '排序',
  `created_at` int(11) NOT NULL DEFAULT 0,
  `updated_at` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`element_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 31 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统-元素表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of element
-- ----------------------------
INSERT INTO `element` VALUES (1, '用户列表页面', 'page', 'user/index', '', 0, 1586873702, 1587131917);
INSERT INTO `element` VALUES (2, '添加用户按钮', 'block', 'storeUser', '', 100, 1586876138, 1587132036);
INSERT INTO `element` VALUES (6, '角色列表页面', 'page', 'role/index', '', 120, 1586964284, 1587229189);
INSERT INTO `element` VALUES (7, '编辑用户页面', 'page', 'user/edit', '', 100, 1587132733, 1587226261);
INSERT INTO `element` VALUES (8, '删除用户按钮', 'block', 'destoryUser', '', 100, 1587134670, 1587215188);
INSERT INTO `element` VALUES (9, '角色授权页面', 'page', 'role/authorize', '', 122, 1587215601, 1587226296);
INSERT INTO `element` VALUES (10, '编辑角色页面', 'page', 'role/edit', '', 122, 1587218299, 1587226270);
INSERT INTO `element` VALUES (11, '删除角色按钮', 'block', 'destroyRole', '', 123, 1587221836, 1587221836);
INSERT INTO `element` VALUES (12, '添加角色按钮', 'block', 'storeRole', '', 121, 1587221920, 1587221920);
INSERT INTO `element` VALUES (13, '元素列表页面', 'page', 'element/index', '', 130, 1587227160, 1587229094);
INSERT INTO `element` VALUES (14, '添加元素按钮', 'block', 'storeElement', '', 100, 1587227878, 1587227934);
INSERT INTO `element` VALUES (15, '编辑元素按钮', 'block', 'editElement', '', 100, 1587228083, 1587228910);
INSERT INTO `element` VALUES (16, '删除元素按钮', 'block', 'destroyElement', '', 100, 1587228132, 1587228905);
INSERT INTO `element` VALUES (17, '接口列表页面', 'page', 'api/index', '', 100, 1587229065, 1587229203);
INSERT INTO `element` VALUES (18, '添加接口按钮', 'block', 'storeApi', '', 100, 1587229150, 1587229210);
INSERT INTO `element` VALUES (19, '编辑接口按钮', 'block', 'editApi', '', 100, 1587229247, 1587229252);
INSERT INTO `element` VALUES (20, '删除接口按钮', 'block', 'destroyApi', '', 100, 1587229279, 1587229279);
INSERT INTO `element` VALUES (21, '菜单列表页面', 'page', 'menu/index', '', 100, 1587229365, 1587229931);
INSERT INTO `element` VALUES (22, '添加菜单按钮', 'block', 'storeMenu', '', 100, 1587229416, 1587229416);
INSERT INTO `element` VALUES (23, '编辑菜单按钮', 'block', 'editMenu', '', 100, 1587229446, 1587229446);
INSERT INTO `element` VALUES (24, '删除菜单按钮', 'block', 'destroyMenu', '', 100, 1587229471, 1587229475);
INSERT INTO `element` VALUES (25, '编辑用户按钮', 'block', 'editUser', '', 100, 1587230184, 1587232487);
INSERT INTO `element` VALUES (26, '角色授权按钮', 'block', 'authorizeRole', '', 100, 1587230290, 1587230290);
INSERT INTO `element` VALUES (27, '编辑角色按钮', 'block', 'editRole', '', 100, 1587230321, 1587230321);
INSERT INTO `element` VALUES (28, '菜单状态更新按钮', 'block', 'menuStatus', '', 100, 1587230555, 1587231038);
INSERT INTO `element` VALUES (29, '用户状态更新按钮', 'block', 'userStatus', '', 100, 1587231062, 1587231104);
INSERT INTO `element` VALUES (30, '角色状态更新按钮', 'block', 'roleStatus', '', 100, 1587231091, 1587231091);

-- ----------------------------
-- Table structure for element_api
-- ----------------------------
DROP TABLE IF EXISTS `element_api`;
CREATE TABLE `element_api`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `element_id` int(11) NOT NULL,
  `api_id` int(11) NOT NULL,
  `created_at` int(11) NOT NULL DEFAULT 0,
  `updated_at` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `element_api`(`element_id`, `api_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 43 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统-元素接口关联表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of element_api
-- ----------------------------
INSERT INTO `element_api` VALUES (1, 1, 1, 1586963593, 1586963593);
INSERT INTO `element_api` VALUES (2, 2, 2, 1586963629, 1586963629);
INSERT INTO `element_api` VALUES (4, 6, 5, 1586964284, 1586964284);
INSERT INTO `element_api` VALUES (6, 1, 6, 1587056673, 1587056673);
INSERT INTO `element_api` VALUES (9, 7, 7, 1587132733, 1587132733);
INSERT INTO `element_api` VALUES (10, 7, 6, 1587132733, 1587132733);
INSERT INTO `element_api` VALUES (11, 7, 3, 1587132733, 1587132733);
INSERT INTO `element_api` VALUES (12, 8, 8, 1587215179, 1587215179);
INSERT INTO `element_api` VALUES (13, 9, 15, 1587218185, 1587218185);
INSERT INTO `element_api` VALUES (14, 9, 14, 1587218185, 1587218185);
INSERT INTO `element_api` VALUES (15, 10, 11, 1587218299, 1587218299);
INSERT INTO `element_api` VALUES (16, 10, 12, 1587218299, 1587218299);
INSERT INTO `element_api` VALUES (17, 10, 10, 1587218299, 1587218299);
INSERT INTO `element_api` VALUES (18, 11, 13, 1587221836, 1587221836);
INSERT INTO `element_api` VALUES (19, 12, 9, 1587221920, 1587221920);
INSERT INTO `element_api` VALUES (20, 13, 23, 1587227825, 1587227825);
INSERT INTO `element_api` VALUES (21, 13, 24, 1587227825, 1587227825);
INSERT INTO `element_api` VALUES (22, 14, 22, 1587227878, 1587227878);
INSERT INTO `element_api` VALUES (23, 15, 26, 1587228083, 1587228083);
INSERT INTO `element_api` VALUES (24, 15, 25, 1587228083, 1587228083);
INSERT INTO `element_api` VALUES (25, 16, 27, 1587228132, 1587228132);
INSERT INTO `element_api` VALUES (26, 17, 16, 1587229065, 1587229065);
INSERT INTO `element_api` VALUES (28, 18, 20, 1587229150, 1587229150);
INSERT INTO `element_api` VALUES (29, 6, 10, 1587229189, 1587229189);
INSERT INTO `element_api` VALUES (30, 17, 17, 1587229203, 1587229203);
INSERT INTO `element_api` VALUES (31, 19, 18, 1587229247, 1587229247);
INSERT INTO `element_api` VALUES (32, 19, 21, 1587229247, 1587229247);
INSERT INTO `element_api` VALUES (33, 20, 19, 1587229280, 1587229280);
INSERT INTO `element_api` VALUES (34, 21, 28, 1587229365, 1587229365);
INSERT INTO `element_api` VALUES (35, 21, 30, 1587229365, 1587229365);
INSERT INTO `element_api` VALUES (36, 22, 29, 1587229416, 1587229416);
INSERT INTO `element_api` VALUES (37, 23, 31, 1587229446, 1587229446);
INSERT INTO `element_api` VALUES (38, 23, 32, 1587229446, 1587229446);
INSERT INTO `element_api` VALUES (39, 24, 33, 1587229471, 1587229471);
INSERT INTO `element_api` VALUES (40, 28, 34, 1587231038, 1587231038);
INSERT INTO `element_api` VALUES (41, 29, 36, 1587231062, 1587231062);
INSERT INTO `element_api` VALUES (42, 30, 35, 1587231091, 1587231091);

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu`  (
  `menu_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `menu_parent_id` int(11) NOT NULL DEFAULT 0 COMMENT '父菜单id',
  `menu_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '菜单名称',
  `menu_icon` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '菜单图标',
  `menu_href` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '菜单跳转链接',
  `menu_desc` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '菜单描述',
  `menu_sort_order` int(11) NOT NULL DEFAULT 0 COMMENT '排序 越小越前',
  `menu_status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0使用中 1停止使用',
  `created_at` int(11) NOT NULL DEFAULT 0,
  `updated_at` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`menu_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 30 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统-菜单表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES (1, 0, '系统管理', 'el-icon-s-platform', '#', '', 0, 0, 1586450123, 1587230604);
INSERT INTO `menu` VALUES (2, 1, '系统配置', '', '2', '', 10, 0, 1586450134, 1586974114);
INSERT INTO `menu` VALUES (3, 1, '权限管理', '', '#', '', 0, 0, 1586450141, 1586800016);
INSERT INTO `menu` VALUES (4, 2, '系统参数配置', '', '4', '', 0, 0, 1586450153, 1586450153);
INSERT INTO `menu` VALUES (5, 2, '系统任务管理', '', '5', '', 0, 0, 1586450159, 1586450159);
INSERT INTO `menu` VALUES (6, 2, '系统日志管理', '', '6', '', 0, 0, 1586450165, 1586450165);
INSERT INTO `menu` VALUES (7, 2, '系统菜单管理', '', '7', '', 0, 0, 1586450170, 1586450170);
INSERT INTO `menu` VALUES (8, 3, '系统角色管理', '', 'role/index', '', 0, 0, 1586450180, 1586450180);
INSERT INTO `menu` VALUES (9, 3, '系统用户管理', '', 'user/index', '', 0, 0, 1586450186, 1586450186);
INSERT INTO `menu` VALUES (10, 0, '微信管理', 'el-icon-chat-round', '10', '', 10, 0, 1586450208, 1586973370);
INSERT INTO `menu` VALUES (11, 10, '微信管理', '', '11', '', 0, 0, 1586450249, 1586450249);
INSERT INTO `menu` VALUES (12, 10, '微信定制', '', '12', '', 0, 0, 1586450258, 1586802900);
INSERT INTO `menu` VALUES (13, 11, '微信接口配置', '', '13', '', 0, 0, 1586450308, 1586450308);
INSERT INTO `menu` VALUES (14, 11, '微信支付配置', '', '14', '', 0, 0, 1586450318, 1586450318);
INSERT INTO `menu` VALUES (15, 12, '微信粉丝管理', '', '15', '', 0, 0, 1586450327, 1586450327);
INSERT INTO `menu` VALUES (16, 12, '微信图文管理', '', '16', '', 0, 0, 1586450332, 1586450332);
INSERT INTO `menu` VALUES (17, 12, '微信菜单配置', '', '17', '', 0, 0, 1586450338, 1586450338);
INSERT INTO `menu` VALUES (18, 12, '回复规则管理', '', '18', '', 0, 0, 1586450344, 1586450344);
INSERT INTO `menu` VALUES (19, 12, '关注回复配置', '', '19', '', 0, 0, 1586450349, 1586450349);
INSERT INTO `menu` VALUES (20, 12, '默认回复配置', '', '20', '', 0, 0, 1586450357, 1586450357);
INSERT INTO `menu` VALUES (21, 3, '系统资源管理', '', '#', '', 0, 0, 1586747221, 1586800031);
INSERT INTO `menu` VALUES (22, 21, '接口管理', '', 'api/index', '', 0, 0, 1586747365, 1586747365);
INSERT INTO `menu` VALUES (23, 21, '元素管理', '', 'element/index', '', 0, 0, 1586747374, 1586747374);
INSERT INTO `menu` VALUES (24, 21, '菜单管理', '', 'menu/index', '', 0, 0, 1586747378, 1586747378);
INSERT INTO `menu` VALUES (27, 0, '错误页面', 'el-icon-info', '', '', 100, 0, 1586938130, 1586979032);
INSERT INTO `menu` VALUES (28, 27, '404', '', 'error/404', '', 100, 0, 1586938169, 1586978957);
INSERT INTO `menu` VALUES (29, 27, '401', '', 'error/401', '', 100, 0, 1586978392, 1586978964);

-- ----------------------------
-- Table structure for role
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role`  (
  `role_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '角色名',
  `role_type` enum('system','custom') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'custom' COMMENT '角色类型 system-内置角色 custom自定义角色',
  `role_desc` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '角色描述',
  `role_status` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '角色状态 0-正常 1-已停用',
  `created_at` int(11) NOT NULL DEFAULT 0,
  `updated_at` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`role_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统-角色表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO `role` VALUES (1, '超级管理员', 'system', 'root', 0, 1586538229, 1586538229);
INSERT INTO `role` VALUES (2, '系统管理员', 'custom', '这是系统级别的管理员', 0, 1586745027, 1586745968);
INSERT INTO `role` VALUES (4, 'test', 'custom', '我是测试角色', 0, 1586746131, 1587232553);

-- ----------------------------
-- Table structure for role_resource
-- ----------------------------
DROP TABLE IF EXISTS `role_resource`;
CREATE TABLE `role_resource`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `resource_type` enum('menu','element') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '资源类型 menu-菜单 element-页面元素',
  `resource_id` int(11) NOT NULL COMMENT '资源id',
  `created_at` int(11) NOT NULL DEFAULT 0,
  `updated_at` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `role_resource`(`role_id`, `resource_type`, `resource_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 130 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统-角色资源表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role_resource
-- ----------------------------
INSERT INTO `role_resource` VALUES (21, 1, 'menu', 21, 1586747453, 1586747453);
INSERT INTO `role_resource` VALUES (22, 1, 'menu', 22, 1586747453, 1586747453);
INSERT INTO `role_resource` VALUES (23, 1, 'menu', 23, 1586747453, 1586747453);
INSERT INTO `role_resource` VALUES (24, 1, 'menu', 24, 1586747453, 1586747453);
INSERT INTO `role_resource` VALUES (26, 1, 'menu', 1, 1586747606, 1586747606);
INSERT INTO `role_resource` VALUES (27, 1, 'menu', 2, 1586747606, 1586747606);
INSERT INTO `role_resource` VALUES (28, 1, 'menu', 3, 1586747606, 1586747606);
INSERT INTO `role_resource` VALUES (29, 1, 'menu', 4, 1586747606, 1586747606);
INSERT INTO `role_resource` VALUES (30, 1, 'menu', 5, 1586747606, 1586747606);
INSERT INTO `role_resource` VALUES (31, 1, 'menu', 6, 1586747606, 1586747606);
INSERT INTO `role_resource` VALUES (32, 1, 'menu', 7, 1586747606, 1586747606);
INSERT INTO `role_resource` VALUES (33, 1, 'menu', 8, 1586747606, 1586747606);
INSERT INTO `role_resource` VALUES (34, 1, 'menu', 9, 1586747606, 1586747606);
INSERT INTO `role_resource` VALUES (35, 1, 'menu', 10, 1586747606, 1586747606);
INSERT INTO `role_resource` VALUES (36, 1, 'menu', 11, 1586747606, 1586747606);
INSERT INTO `role_resource` VALUES (37, 1, 'menu', 12, 1586747606, 1586747606);
INSERT INTO `role_resource` VALUES (38, 1, 'menu', 13, 1586747606, 1586747606);
INSERT INTO `role_resource` VALUES (39, 1, 'menu', 14, 1586747606, 1586747606);
INSERT INTO `role_resource` VALUES (40, 1, 'menu', 15, 1586747606, 1586747606);
INSERT INTO `role_resource` VALUES (41, 1, 'menu', 16, 1586747606, 1586747606);
INSERT INTO `role_resource` VALUES (42, 1, 'menu', 17, 1586747606, 1586747606);
INSERT INTO `role_resource` VALUES (43, 1, 'menu', 18, 1586747606, 1586747606);
INSERT INTO `role_resource` VALUES (44, 1, 'menu', 19, 1586747606, 1586747606);
INSERT INTO `role_resource` VALUES (45, 1, 'menu', 20, 1586747606, 1586747606);
INSERT INTO `role_resource` VALUES (47, 1, 'element', 1, 1586747606, 1586747606);
INSERT INTO `role_resource` VALUES (53, 1, 'element', 6, 1586973024, 1586973024);
INSERT INTO `role_resource` VALUES (55, 2, 'menu', 1, 1586973852, 1586973852);
INSERT INTO `role_resource` VALUES (56, 2, 'menu', 2, 1586973852, 1586973852);
INSERT INTO `role_resource` VALUES (57, 2, 'menu', 4, 1586973852, 1586973852);
INSERT INTO `role_resource` VALUES (58, 2, 'menu', 5, 1586973852, 1586973852);
INSERT INTO `role_resource` VALUES (59, 2, 'menu', 6, 1586973852, 1586973852);
INSERT INTO `role_resource` VALUES (60, 2, 'menu', 7, 1586973852, 1586973852);
INSERT INTO `role_resource` VALUES (61, 2, 'menu', 10, 1586973852, 1586973852);
INSERT INTO `role_resource` VALUES (62, 2, 'menu', 11, 1586973852, 1586973852);
INSERT INTO `role_resource` VALUES (63, 2, 'menu', 13, 1586973852, 1586973852);
INSERT INTO `role_resource` VALUES (64, 2, 'menu', 14, 1586973852, 1586973852);
INSERT INTO `role_resource` VALUES (65, 2, 'menu', 12, 1586973852, 1586973852);
INSERT INTO `role_resource` VALUES (66, 2, 'menu', 15, 1586973852, 1586973852);
INSERT INTO `role_resource` VALUES (67, 2, 'menu', 16, 1586973852, 1586973852);
INSERT INTO `role_resource` VALUES (68, 2, 'menu', 17, 1586973852, 1586973852);
INSERT INTO `role_resource` VALUES (69, 2, 'menu', 18, 1586973852, 1586973852);
INSERT INTO `role_resource` VALUES (70, 2, 'menu', 19, 1586973852, 1586973852);
INSERT INTO `role_resource` VALUES (71, 2, 'menu', 20, 1586973852, 1586973852);
INSERT INTO `role_resource` VALUES (72, 2, 'element', 1, 1586973852, 1586973852);
INSERT INTO `role_resource` VALUES (75, 2, 'element', 6, 1586973852, 1586973852);
INSERT INTO `role_resource` VALUES (76, 1, 'menu', 27, 1586978435, 1586978435);
INSERT INTO `role_resource` VALUES (77, 1, 'menu', 28, 1586978435, 1586978435);
INSERT INTO `role_resource` VALUES (78, 1, 'menu', 29, 1586978435, 1586978435);
INSERT INTO `role_resource` VALUES (79, 1, 'element', 2, 1587024465, 1587024465);
INSERT INTO `role_resource` VALUES (80, 4, 'menu', 10, 1587131760, 1587131760);
INSERT INTO `role_resource` VALUES (81, 4, 'menu', 12, 1587131760, 1587131760);
INSERT INTO `role_resource` VALUES (82, 4, 'menu', 15, 1587131760, 1587131760);
INSERT INTO `role_resource` VALUES (83, 4, 'menu', 16, 1587131760, 1587131760);
INSERT INTO `role_resource` VALUES (84, 4, 'menu', 17, 1587131760, 1587131760);
INSERT INTO `role_resource` VALUES (85, 4, 'menu', 18, 1587131760, 1587131760);
INSERT INTO `role_resource` VALUES (86, 4, 'menu', 19, 1587131760, 1587131760);
INSERT INTO `role_resource` VALUES (87, 4, 'menu', 20, 1587131760, 1587131760);
INSERT INTO `role_resource` VALUES (88, 1, 'element', 7, 1587215220, 1587215220);
INSERT INTO `role_resource` VALUES (90, 1, 'element', 8, 1587215488, 1587215488);
INSERT INTO `role_resource` VALUES (91, 1, 'element', 9, 1587221992, 1587221992);
INSERT INTO `role_resource` VALUES (92, 1, 'element', 10, 1587221992, 1587221992);
INSERT INTO `role_resource` VALUES (93, 1, 'element', 11, 1587221992, 1587221992);
INSERT INTO `role_resource` VALUES (94, 1, 'element', 12, 1587221992, 1587221992);
INSERT INTO `role_resource` VALUES (95, 1, 'element', 13, 1587227994, 1587227994);
INSERT INTO `role_resource` VALUES (96, 1, 'element', 14, 1587227994, 1587227994);
INSERT INTO `role_resource` VALUES (97, 1, 'element', 15, 1587228196, 1587228196);
INSERT INTO `role_resource` VALUES (98, 1, 'element', 16, 1587228196, 1587228196);
INSERT INTO `role_resource` VALUES (99, 1, 'element', 17, 1587229601, 1587229601);
INSERT INTO `role_resource` VALUES (100, 1, 'element', 18, 1587229601, 1587229601);
INSERT INTO `role_resource` VALUES (101, 1, 'element', 19, 1587229601, 1587229601);
INSERT INTO `role_resource` VALUES (102, 1, 'element', 20, 1587229601, 1587229601);
INSERT INTO `role_resource` VALUES (103, 1, 'element', 21, 1587229601, 1587229601);
INSERT INTO `role_resource` VALUES (105, 1, 'element', 23, 1587229601, 1587229601);
INSERT INTO `role_resource` VALUES (106, 1, 'element', 24, 1587229601, 1587229601);
INSERT INTO `role_resource` VALUES (107, 1, 'element', 22, 1587229793, 1587229793);
INSERT INTO `role_resource` VALUES (108, 2, 'menu', 3, 1587230042, 1587230042);
INSERT INTO `role_resource` VALUES (109, 2, 'menu', 8, 1587230042, 1587230042);
INSERT INTO `role_resource` VALUES (110, 2, 'menu', 9, 1587230042, 1587230042);
INSERT INTO `role_resource` VALUES (111, 1, 'element', 25, 1587230339, 1587230339);
INSERT INTO `role_resource` VALUES (112, 1, 'element', 26, 1587230339, 1587230339);
INSERT INTO `role_resource` VALUES (113, 1, 'element', 27, 1587230339, 1587230339);
INSERT INTO `role_resource` VALUES (114, 1, 'element', 28, 1587231116, 1587231116);
INSERT INTO `role_resource` VALUES (115, 1, 'element', 29, 1587231116, 1587231116);
INSERT INTO `role_resource` VALUES (116, 1, 'element', 30, 1587231116, 1587231116);
INSERT INTO `role_resource` VALUES (117, 4, 'menu', 27, 1587232520, 1587232520);
INSERT INTO `role_resource` VALUES (118, 4, 'menu', 28, 1587232520, 1587232520);
INSERT INTO `role_resource` VALUES (119, 4, 'menu', 29, 1587232520, 1587232520);
INSERT INTO `role_resource` VALUES (120, 2, 'menu', 21, 1587232885, 1587232885);
INSERT INTO `role_resource` VALUES (121, 2, 'menu', 22, 1587232885, 1587232885);
INSERT INTO `role_resource` VALUES (122, 2, 'menu', 23, 1587232885, 1587232885);
INSERT INTO `role_resource` VALUES (123, 2, 'menu', 24, 1587232885, 1587232885);
INSERT INTO `role_resource` VALUES (124, 2, 'menu', 27, 1587232885, 1587232885);
INSERT INTO `role_resource` VALUES (125, 2, 'menu', 28, 1587232885, 1587232885);
INSERT INTO `role_resource` VALUES (126, 2, 'menu', 29, 1587232885, 1587232885);
INSERT INTO `role_resource` VALUES (127, 2, 'element', 13, 1587232926, 1587232926);
INSERT INTO `role_resource` VALUES (128, 2, 'element', 17, 1587232926, 1587232926);
INSERT INTO `role_resource` VALUES (129, 2, 'element', 21, 1587232926, 1587232926);

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名',
  `user_nickname` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '昵称',
  `user_password` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码',
  `user_mobile` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '手机',
  `user_email` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '邮箱',
  `user_refresh_token` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `user_status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '状态 0-正常 1-禁用',
  `created_at` int(11) NOT NULL DEFAULT 0,
  `updated_at` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`user_id`) USING BTREE,
  UNIQUE INDEX `username`(`user_name`) USING BTREE,
  UNIQUE INDEX `mobile`(`user_mobile`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统-用户表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'zombie', '这是僵尸吗', '$2y$10$gw0jyEIU4IWYg0/EIDs4zuNjjBdxPeiR5bU6f575YNGH.cnT1Gnpy', '18357551108', 'zombie@foxmail.com', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczpcL1wvd3d3LmNzaGFwdHg0ODY5LmNvbSIsImF1ZCI6Imh0dHBzOlwvXC93d3cuY3NoYXB0eDQ4NjkuY29tIiwiaWF0IjoxNjI4Njg4NDcwLCJuYmYiOjE2Mjg2ODg0NzAsImV4cCI6MTYyOTI5MzI3MCwiZGF0YSI6IiJ9.NrgGMxCj29TDmJk64oSKqdE3QD28YXbLR41mq6kCbMU', 0, 1586538229, 1587132544);
INSERT INTO `user` VALUES (2, 'test', '测试账号', '$2y$10$fFJqnUeWOUEdwKAxtnVo4eD8ecLsDc0sGtpAtRc7WukXmqIdIJIqm', '18234065200', 'test@foxmail.com', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczpcL1wvd3d3LmNzaGFwdHg0ODY5LmNvbSIsImF1ZCI6Imh0dHBzOlwvXC93d3cuY3NoYXB0eDQ4NjkuY29tIiwiaWF0IjoxNTg3NDQ2OTA2LCJuYmYiOjE1ODc0NDY5MDYsImV4cCI6MTU4ODA1MTcwNiwiZGF0YSI6IiJ9.oVU7Z_Hr38QNso13y42faKCAzfwdeMBmsc_Gdc92oMI', 0, 1586627315, 1587230057);
INSERT INTO `user` VALUES (3, 'test1', '', '$2y$10$gKlEGM/bSYQVzvKXqJgzLOiXp79i55R4ujn3o30tSYT5U9lsG9Ilu', '18234065201', 'test1@foxmail.com', '', 1, 1586632125, 1587231403);
INSERT INTO `user` VALUES (4, 'test2', '', '$2y$10$8BzSy2wDfTuH5DxH40.cNOdMws70T5GfF8UdPomb3H8OdricBdB7K', '18234065202', 'test2@foxmail.com', '', 1, 1586632489, 1586740461);
INSERT INTO `user` VALUES (5, 'test3', '', '$2y$10$xKD1Rwc1MSwd9AMH7qYxzeaQe7nW.7tWrh.NQw7hXjk8NuWFRyGqq', '18234065203', 'test3@foxmail.com', '', 1, 1586708616, 1587232568);

-- ----------------------------
-- Table structure for user_role
-- ----------------------------
DROP TABLE IF EXISTS `user_role`;
CREATE TABLE `user_role`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` int(11) NOT NULL DEFAULT 0,
  `updated_at` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `user_role`(`user_id`, `role_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统-用户角色关联表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_role
-- ----------------------------
INSERT INTO `user_role` VALUES (1, 1, 1, 0, 0);
INSERT INTO `user_role` VALUES (3, 3, 1, 1586632125, 1586632125);
INSERT INTO `user_role` VALUES (4, 4, 1, 1586632489, 1586632489);
INSERT INTO `user_role` VALUES (5, 5, 1, 1586708616, 1586708616);
INSERT INTO `user_role` VALUES (7, 2, 2, 1587230057, 1587230057);

SET FOREIGN_KEY_CHECKS = 1;
