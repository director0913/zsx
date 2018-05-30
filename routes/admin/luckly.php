<?php
$router->group(['prefix' => 'luckly'],function ($router)
{
	$router->get('ajaxIndex','LucklyController@ajaxIndex')->name('luckly.ajaxIndex');
	$router->any('edit/{id}','LucklyController@edit')->name('luckly.edit');
	$router->any('destory/{id}','LucklyController@destory')->name('luckly.destory');
	$router->get('create/','LucklyController@create')->name('luckly.create');
	$router->get('/lists/{p?}','LucklyController@lists')->name('luckly.lists');
	$router->get('/show/{id}','LucklyController@show')->name('luckly.show');
	$router->any('total/{id}','LucklyController@total')->name('luckly.total');
	$router->any('tosign/{id}','LucklyController@tosign')->name('luckly.tosign');
	$router->any('roolbacksign/{id}','LucklyController@roolbacksign')->name('luckly.roolbacksign');
	$router->any('totalDel/{id}','LucklyController@totalDel')->name('luckly.totalDel');
	$router->any('{id}/downexcel','LucklyController@downexcel')->name('luckly.downexcel');
});
$router->resource('luckly','LucklyController');