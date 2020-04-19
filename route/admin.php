<?php

use think\facade\Route;

Route::group('admin', function () {
    // 登录相关
    Route::post('login/signIn', 'login/signIn');
    Route::post('login/singUp', 'login/singUp');
    Route::post('login/check', 'login/check');
    Route::post('login/refresh', 'login/refresh');
    Route::post('login/signOut', 'login/signOut');
    Route::post('login/mini', 'login/mini');

})->prefix('admin/');

//jwt认证
Route::group('admin', function () {
    // 登录相关
    Route::post('login/bind', 'login/bind');

    // 用户相关
    Route::post('user/index', 'user/index');
    Route::post('user/preview', 'user/preview');
    Route::post('user/store', 'user/store');
    Route::post('user/show', 'user/show');
    Route::post('user/update', 'user/update');
    Route::post('user/status', 'user/status');
    Route::post('user/destroy', 'user/destroy');
    Route::post('user/permission', 'user/permission');

    // 角色相关
    Route::post('role/index', 'role/index');
    Route::post('role/preview', 'role/preview');
    Route::post('role/store', 'role/store');
    Route::post('role/show', 'role/show');
    Route::post('role/update', 'role/update');
    Route::post('role/status', 'role/status');
    Route::post('role/destroy', 'role/destroy');
    Route::post('role/authorize', 'role/authorize');
    Route::post('role/authorizePreview', 'role/authorizePreview');

    // 菜单相关
    Route::post('menu/index', 'menu/index');
    Route::post('menu/preview', 'menu/preview');
    Route::post('menu/store', 'menu/store');
    Route::post('menu/show', 'menu/show');
    Route::post('menu/update', 'menu/update');
    Route::post('menu/status', 'menu/status');
    Route::post('menu/destroy', 'menu/destroy');

    // 元素相关
    Route::post('element/index', 'element/index');
    Route::post('element/preview', 'element/preview');
    Route::post('element/store', 'element/store');
    Route::post('element/show', 'element/show');
    Route::post('element/update', 'element/update');
    Route::post('element/destroy', 'element/destroy');

    // api相关
    Route::post('api/index', 'api/index');
    Route::post('api/preview', 'api/preview');
    Route::post('api/store', 'api/store');
    Route::post('api/show', 'api/show');
    Route::post('api/update', 'api/update');
    Route::post('api/destroy', 'api/destroy');

})->prefix('admin/')->middleware(['jwt']);
