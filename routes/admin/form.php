<?php
$router->group(['prefix' => 'form'],function ($router)
{
	$router->get('ajaxIndex','FormController@ajaxIndex')->name('form.ajaxIndex');
	$router->get('preview/{id}','FormController@preview')->name('form.preview');
	$router->get('custom/{id}','FormController@custom')->name('form.custom');
	$router->any('edit/{id}','FormController@edit')->name('form.edit');
	$router->any('destory/{id}','FormController@destory')->name('form.destory');
	$router->get('create/','FormController@create')->name('form.create');
	$router->get('/lists/{id?}','FormController@lists')->name('form.lists');
	$router->get('/show/{id}','FormController@show')->name('form.show');
	$router->any('{id}/downexcel','FormController@downexcel/{id}')->name('form.downexcel/{id}');
});
$router->resource('form','FormController');