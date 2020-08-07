<?php
namespace Group;
use LSYS\Rbac\VisitorGroup;
use LSYS\Rbac\Role;
use LSYS\Rbac\RoleGroup;
/**
 * 基于数据表的用户组类
 */
class DomeData implements VisitorGroup{
	/**
	 * @var RoleGroup
	 */
	protected $_role_group;
	public function __construct(){
		$this->_role_group=new RoleGroup();
		$table=\LSYS\Database\DI::get()->db()->tablePrefix()."role_user";;
		$sql="select * from {$table} where group_name='member'";
		foreach (\LSYS\Database\DI::get()->db()->getConnect()->query($sql) as $role_row){
		    $role=null;
		    if (substr($role_row['role_str'], 0,2)=='db'){
		        $role= new \Role\DomeData(substr($role_row['role_str'], 3));
		    }
			if (!$role instanceof Role)continue;
			$this->_role_group->add($role);
		}
	}
	public function groupName(){
	    return "member";
	}
	/**
	 * @return RoleGroup
	 */
	public function roleGroup(){
		return $this->_role_group;
	}
}