<?php
$router->group(['prefix' => 'activity'],function ($router)
{
	$router->get('ajaxIndex','ActivityController@ajaxIndex')->name('activity.ajaxIndex');
	$router->any('edit/{id}','ActivityController@edit')->name('activity.edit');
	$router->any('destory/{id}','ActivityController@destory')->name('activity.destory');
	$router->get('create/','ActivityController@create')->name('activity.create');
	$router->get('/lists/{p?}','ActivityController@lists')->name('activity.lists');
	$router->get('/show/{id}','ActivityController@show')->name('activity.show');
	$router->any('total/{id}','ActivityController@total')->name('activity.total');
	$router->any('tosign/{id}','ActivityController@tosign')->name('activity.tosign');
	$router->any('roolbacksign/{id}','ActivityController@roolbacksign')->name('activity.roolbacksign');
	$router->any('totalDel/{id}','ActivityController@totalDel')->name('activity.totalDel');
	$router->any('{id}/downexcel','ActivityController@downexcel')->name('activity.downexcel');
});
$router->resource('activity','ActivityController');