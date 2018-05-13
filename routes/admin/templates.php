<?php
$router->group(['prefix' => 'templates'],function ($router)
{
	$router->get('ajaxIndex','TemplatesController@ajaxIndex')->name('templates.ajaxIndex');
	$router->get('preview/{id}','TemplatesController@preview')->name('templates.preview');
	$router->any('settings','TemplatesController@settings')->name('templates.settings');
	$router->post('/store','TemplatesController@store')->name('templates.store');
});
$router->resource('templates','TemplatesController');