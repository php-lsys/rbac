<?php
namespace Visitor;
use LSYS\Rbac\Visitor;
use LSYS\Rbac\RoleGroup;
/**
 * 游客实现
 */
class DomeGuest implements Visitor{
	public function visitorGroup(){
		return NULL;
	}
	public function roleGroup(){
		return (new RoleGroup());
	}
}
