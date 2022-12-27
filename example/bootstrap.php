<?php

require __DIR__ . '/vendor/autoload.php';

$projectPath = dirname(__DIR__);

$settings = [
	'errors' => [
/*
		'expose' => true,
		'log' => '/tmp/app/app.log',
		'email' => [
			'from' => 'from@example.com',
			'to' => 'to@example.com'
		]
*/
	],
	'mail' => [
		'host' => 'smtp.example.com',
		'port' => 465,
		'secure' => 'ssl',
		'username' => 'user@example.com',
		'password' => 'password'
	],
	'paths' => [
		'code' => "{$projectPath}/code/src",
		'www' => '/tmp/app/www/'
	],
	'project' => 'app',
	'timeZone' => 'America/New_York'
];
