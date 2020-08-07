<?php
namespace LSYS\Rbac;
/**
 * 访客组
 * 用于对某些具有公共角色的访客的统一角色赋值
 * 如:会员 高级会员 等,可以封装层访客组,使这些访客有统一的角色
 */
interface VisitorGroup{
	/**
	 * 返回角色组名
	 * @return string
	 */
	public function groupName();
	/**
	 * 返回角色组
	 * @return RoleGroup
	 */
	public function roleGroup();
}