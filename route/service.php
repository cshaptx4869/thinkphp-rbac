<?php

use think\facade\Route;

//公共服务
Route::group('service', function () {
    Route::get('index/hello', 'index/hello');
    Route::post('index/uploadImage', 'index/uploadImage');
    Route::post('index/sendSms', 'index/sendSms');
    Route::post('index/sendEmail', 'index/sendEmail');
    //小程序获取openid
    Route::post('weixin/miniOpenid', 'weixin/miniOpenid');
})->prefix('service/');
