<?php
use OP\DomeCURD;
use Res\DomeTestRes;
use OP\DomeTestOP;
use Res\DomeData;
use Res\DomeUserData;
$loader=include_once __DIR__."/bootstarp.php";
$loader->setPsr4("",array("classes"));

$user=1;

$r = (new DomeRbac($user))
    ->addOp(new DomeTestRes(), new DomeTestOP())
	->addOps([
	    [new DomeTestRes(),new DomeTestOP()]
	 	,
	    [new DomeData(11),new DomeCURD([DomeCURD::DELETE,DomeCURD::INSERT])]
	 	,
	    [new DomeUserData(11,11),new DomeCURD(DomeCURD::UPDATE)]
	])
	->check();


var_dump($r->getMessage());
echo "<pre>";
print_r($r);

// //设置权限
var_dump(\Role\DomeData::opSets(
	[new \Role\DomeData(1), new DomeData(1),new DomeCURD(DomeCURD::UPDATE)],
    [new \Role\DomeData(1), new DomeData(2),new DomeCURD(DomeCURD::UPDATE)],
    [new \Role\DomeData(1), new DomeData(3),new DomeCURD(DomeCURD::SELECT)],
    [new \Role\DomeData(1), new DomeData(1),new DomeCURD(DomeCURD::SELECT)]
));