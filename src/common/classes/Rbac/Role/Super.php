<?php
namespace LSYS\Rbac\Role;
use LSYS\Rbac\Role;
/**
 * 超级用户角色
 */
final class Super implements Role{
	/**
	 * {@inheritDoc}
	 * @see \LSYS\Rbac\Role::getToken()
	 */
	public function getToken(){
		return NULL;
	}
	/**
	 * @param Super[] $roles
	 * @param \LSYS\Rbac\Res[] $ress
	 * @return number[]
	 */
	public static function fetch(array $roles,array $ress){
		$access=[];
		foreach ($ress as $v){
			$access[$v->getToken()]=~0;
		}
		return $access;
	}
}