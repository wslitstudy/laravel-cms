<?php

Route::get('/admins', 'Admin\DefaultController@index')->middleware(['admin.auth']);

Route::get('/admin/login', 'Admin\DefaultController@login');
Route::post('/admin/doLogin', 'Admin\DefaultController@store');

Route::get('/admin/logout', 'Admin\DefaultController@logout');

Route::namespace('Admin')->middleware(['admin.auth'])->prefix('admin')->group(function () {

    //上传
    Route::post('/upload/editor','UploadController@editor');
    Route::post('/upload/image','UploadController@image');

    //权限管理
    Route::delete('/manage/disabled/{id}', 'ManageController@disabled');
    Route::resource('/manage', 'ManageController');
    Route::resource('/role', 'RoleController');
    Route::resource('/menu', 'MenuController');
    Route::resource('/power', 'PowerController');

    //配置
    Route::get('/config', 'ConfigController@index');
    Route::get('/config/upload', 'ConfigController@upload');
    Route::post('/config/doUpload', 'ConfigController@doUpload');
    Route::post('/config/revise', 'ConfigController@revise');
    Route::get('/config/sms', 'ConfigController@sms');
    Route::get('/config/reward', 'ConfigController@reward');

    //内容管理
    Route::resource('/notice', 'NoticeController');
    Route::resource('/article', 'ArticleController');
    Route::resource('/banner', 'BannerController');
});
