<?php
$router->group(['prefix' => 'activity'],function ($router)
{
	$router->get('ajaxIndex','ActivityController@ajaxIndex')->name('activity.ajaxIndex');
	$router->get('preview/{id}','ActivityController@preview')->name('activity.preview');
	$router->get('custom/{id}','ActivityController@custom')->name('activity.custom');
	$router->any('edit/{id}','ActivityController@edit')->name('activity.edit');
	$router->any('destory/{id}','ActivityController@destory')->name('activity.destory');
	$router->get('create/','ActivityController@create')->name('activity.create');
	$router->get('/lists/{id?}','ActivityController@lists')->name('activity.lists');
	$router->get('/show/{id}','ActivityController@show')->name('activity.show');
	$router->any('/answer','ActivityController@answer')->name('activity.answer');
	$router->any('total/{id}','ActivityController@total')->name('activity.total');
});
$router->resource('activity','ActivityController');