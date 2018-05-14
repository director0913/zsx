<?php
$router->group(['prefix' => 'music'],function ($router)
{
	$router->get('ajaxIndex','MusicController@ajaxIndex')->name('music.ajaxIndex');
	$router->post('store','MusicController@store')->name('music.custom');
	$router->any('edit/{id}','MusicController@edit')->name('music.edit');
	$router->any('destory/{id}','MusicController@destory')->name('music.destory');
	$router->get('create/','MusicController@create')->name('music.create');
	$router->get('/lists/{id?}','MusicController@lists')->name('music.lists');
	$router->get('/show/{id}','MusicController@show')->name('music.show');
});
$router->resource('music','MusicController');