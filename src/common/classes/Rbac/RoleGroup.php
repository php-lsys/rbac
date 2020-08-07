<?php
namespace LSYS\Rbac;
class RoleGroup{
	/**
	 * @var array
	 */
	protected $_roles=[];
	/**
	 * 汇总角色,得到角色类型
	 * @return Role[]
	 */
	public function group(){
		return array_unique(array_keys($this->_roles));
	}
	/**
	 * 根据角色类型返回该类型角色
	 * @param string $class
	 * @return array
	 */
	public function find($class){
		if (isset($this->_roles[$class]))return array_values($this->_roles[$class]);
		return [];
	}
	/**
	 * 添加角色
	 * @param Role $role
	 * @return \LSYS\Rbac\RoleGroup
	 */
	public function add(Role $role){
		//合并相同角色...
		$this->_roles[get_class($role)][$role->getToken()]=$role;
		return $this;
	}
	/**
	 * 合并角色组
	 * @param RoleGroup $roleg1
	 * @param RoleGroup $roleg2
	 * @return RoleGroup
	 */
	public static function merge(RoleGroup $roleg1,RoleGroup $roleg2){
		$obj=new static();
		foreach ($roleg1->_roles as $v){
			foreach ($v as $c)$obj->add($c);
		}
		foreach ($roleg2->_roles as $v){
			foreach ($v as $c)$obj->add($c);
		}
		return $obj;
	}
}
