<?php
namespace Menu;
use Res\DomeData;
use OP\DomeTestOP;
use Res\DomeTestRes;
class TestMenu1 extends \LSYS\Rbac\Menu{
	const HOME="home";
	const HOME1="home1";
	public function __construct(){
		$data=array("text"=>"显示文字","url"=>"http://baidu.com");
		$this->add(self::HOME, [new DomeData(1111111111),new DomeTestOP()],$data);
		$this->add(self::HOME1, [new DomeTestRes(),new DomeTestOP()],$data);
	}
}