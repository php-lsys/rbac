<?php
namespace Res;
use LSYS\Rbac\Res;
class DomeTestRes implements Res{
	public function __toString(){
		return "全局测试";
	}
	public function getToken(){
		return "test_dome";
	}
}