<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


Auth::routes();
Route::get('/', function () {
	return redirect('/admin/dash');
});
Route::get('/home', 'HomeController@index');

Route::group(['prefix' => 'admin','namespace' => 'Admin','middleware' => ['auth']],function ($router)
{
	$router->get('/dash','DashboardController@index')->name('system.index');
	$router->get('/i18n', 'DashboardController@dataTableI18n');
	// 权限
	require(__DIR__ . '/admin/permission.php');
	// 角色
	require(__DIR__ . '/admin/role.php');
	// 用户
	require(__DIR__ . '/admin/user.php');
	// 菜单
	require(__DIR__ . '/admin/menu.php');
	// 模版列表
	require(__DIR__ . '/admin/templates.php');
	//微表单
	require(__DIR__ . '/admin/form.php');
	//微活动
	require(__DIR__ . '/admin/activity.php');
	//背景音乐
	require(__DIR__ . '/admin/music.php');

});

//预览
Route::get('form/custom/{id}', 'FormController@custom');
Route::post('form/answer/', 'FormController@answer');
Route::any('activity/create/{id}/now/{id1}', 'ActivityController@create');
Route::post('activity/store', 'ActivityController@store');
//大转盘存储
Route::post('luckly/store', 'LucklyController@store');
Route::get('luckly/show/{id}/{collect_id?}', 'LucklyController@show');
Route::post('luckly/collect', 'LucklyController@collect');
Route::post('/luckly/ajaxCut_priceButton', 'LucklyController@ajaxCut_priceButton');

Route::get('activity/show/{id}/{collect_id?}', 'ActivityController@show');
Route::post('activity/collect', 'ActivityController@collect');
Route::post('/activity/ajaxCut_priceButton', 'ActivityController@ajaxCut_priceButton');
//检测是否可以参加活动
Route::post('activity/ajaxJoinButton', 'ActivityController@ajaxJoinButton');


# 用户点击登录按钮时请求的地址
Route::get('/oauth', 'HomeController@oauth');

# 微信接口回调地址
Route::get('/callback', 'HomeController@callback');
Route::get('/tokenSignature', 'HomeController@tokenSignature');