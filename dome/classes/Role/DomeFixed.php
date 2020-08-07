<?php
namespace Role;
use LSYS\Config\File;

/**
 * 基于配置的角色基类
 */
class DomeFixed extends \LSYS\Rbac\Role\Fixed{
	/**
	 * 得到角色标识
	 * @return string
	 */
	public function getToken(){
		return 'fixed-'.$this->name;
	}
	public static function config() {
	    return (new File("rbac.op"))->asArray();
	}
}


