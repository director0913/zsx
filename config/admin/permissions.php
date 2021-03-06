
<?php
return [
	'permission' => [
		'list' 		=> 'permission.list',
		'create' 	=> 'permission.create',
		'edit' 		=> 'permission.edit',
		'destroy' 	=> 'permission.destroy',
	],
	'role' => [
		'list' 		=> 'role.list',
		'create' 	=> 'role.create',
		'edit' 		=> 'role.edit',
		'destroy' 	=> 'role.destroy',
		'show' 		=> 'role.show',
	],
	'user' => [
		'list' 		=> 'user.list',
		'create' 	=> 'user.create',
		'edit' 		=> 'user.edit',
		'destroy' 	=> 'user.destroy',
		'show' 		=> 'user.show',
		'reset' 	=> 'user.reset',
	],
	'menu' => [
		'list' 		=> 'menu.list',
		'create' 	=> 'menu.create',
		'edit' 		=> 'menu.edit',
		'orderable' => 'menu.edit',
		'destroy' 	=> 'menu.destroy',
		'show' 		=> 'menu.show',
	],
	'log' => [
		'list' 		=> 'log.list',
		'destroy' 	=> 'log.destroy',
		'show' 		=> 'log.show',
		'download' 	=> 'log.download',
		'filter' 	=> 'log.filter',
	],
	'form' => [
		'list' 		=> 'form.list',
		'destroy' 	=> 'form.destroy',
		'show' 		=> 'form.show',
		'edit' 	=> 'form.edit',
		'filter' 	=> 'form.filter',
		'downexcel' 	=> 'form.downexcel',
	],
	'activity' => [
		'list' 		=> 'activity.list',
		'destroy' 	=> 'activity.destroy',
		'show' 		=> 'activity.show',
		'edit' 	=> 'activity.edit',
		'create' 	=> 'activity.create',
		'toSign' 	=> 'activity.toSign',
		'downexcel' 	=> 'activity.downexcel',
		'tosign' 	=> 'activity.tosign',
		'preview' 	=> 'activity.preview',
	],
	'music' => [
		'list' 		=> 'music.list',
		'destroy' 	=> 'music.destroy',
		'show' 		=> 'music.show',
		'edit' 	=> 'music.edit',
		'create' 	=> 'music.create',
	],

	'system' => [
		'list' => 'system.index'
	]
];