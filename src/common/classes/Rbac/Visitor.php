<?php
namespace LSYS\Rbac;
interface Visitor{
	/**
	 * 返回访客组,如果访客无访客组,返回NULL
	 * @return VisitorGroup|NULL
	 */
	public function visitorGroup();
	/**
	 * 返回访客的所有角色
	 * @return RoleGroup
	 */
	public function roleGroup();
}