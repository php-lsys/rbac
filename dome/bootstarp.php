<?php
defined('LSYS_PEAK_MEMORY')||define('LSYS_PEAK_MEMORY',memory_get_peak_usage());
defined('LSYS_START_TIME')||define('LSYS_START_TIME',microtime(TRUE));
$r=include_once __DIR__."/../vendor/autoload.php";
LSYS\Config\File::dirs(array(
	__DIR__."/config",
));
LSYS\Core::sets(array(
    'environment'       => \LSYS\Core::DEVELOP,
));
return $r;
