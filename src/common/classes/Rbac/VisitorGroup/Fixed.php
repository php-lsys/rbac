<?php
namespace LSYS\Rbac\VisitorGroup;
use LSYS\Rbac\VisitorGroup;
use LSYS\Rbac\RoleGroup;
/**
 * 基于配置的用户组基类
 */
abstract class Fixed implements VisitorGroup{
	/**
	 * @var RoleGroup
	 */
	protected $_role_group;
	public function __construct(){
		$this->_role_group=new RoleGroup();
	}
	/**
	 * {@inheritDoc}
	 * @see \LSYS\Rbac\VisitorGroup::groupName()
	 */
	public function groupName(){
		return get_called_class();
	}
	/**
	 * {@inheritDoc}
	 * @see \LSYS\Rbac\VisitorGroup::roleGroup()
	 */
	public function roleGroup(){
		return $this->_role_group;
	}
}