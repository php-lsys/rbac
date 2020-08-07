<?php
namespace LSYS\Rbac;
/**
 * 实现参阅dome 
 */
interface Res{
	/**
	 * 资源标识
	 */
	public function getToken();
	/**
	 * 资源描述
	 */
	public function __toString();
}