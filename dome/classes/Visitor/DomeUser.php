<?php
namespace Visitor;
/**
 * 用户实现
 */
class DomeUser extends DomeGuest{
	public function __construct($uid){
		
	}
	public function visitorGroup(){
	    // 		return new \Group\DomeMember();
	    return new \Group\DomeDBMember();
	}
	public function roleGroup(){
		$rg=parent::roleGroup();
// 		$rg->add($role);
		return $rg;
	}
}