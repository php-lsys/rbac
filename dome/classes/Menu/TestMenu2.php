<?php
namespace Menu;
use Res\DomeTestRes;
use OP\DomeTestOP;
use LSYS\Rbac\Menu;
class TestMenu2 extends Menu{
	const HOME="home";
	const HOME1="home1";
	public function __construct(){
		$data=array("text"=>"显示文字","url"=>"http://baidu.com");
		$this->add(self::HOME, [new DomeTestRes(),new DomeTestOP()],$data);
		$this->add(self::HOME1, [new DomeTestRes(),new DomeTestOP()],$data);
	}
}