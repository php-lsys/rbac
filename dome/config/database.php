<?php
return array(
	"mysqli"=>array(
		"type"=>\LSYS\Database\MYSQLi::class,
		"charset"=>"UTF8",
		"table_prefix"=>"yaf_",
		"connection"=>array(
			'database' => 'test',
			'hostname' => '127.0.0.1',
			'username' => 'root',
			'password' => '',
			'weight'	 => 1,
			'persistent' => FALSE,
			"variables"=>array(
			),
		),
	)
);