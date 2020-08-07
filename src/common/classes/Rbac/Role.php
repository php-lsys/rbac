<?php
namespace LSYS\Rbac;
interface Role{
	/**
	 * 得到角色标识
	 * @return string
	 */
	public function getToken();
	/**
	 * 得到指定角色的授权详细
	 * 返回为 资源标识=>权限 的数组
	 * @param Role[] $roles
	 * @param Res[] $ress
	 * @return []
	 */
	public static function fetch(array $roles,array $ress);	
}