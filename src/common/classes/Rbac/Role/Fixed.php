<?php
namespace LSYS\Rbac\Role;
use LSYS\Rbac\Role;
use LSYS\Rbac\Res;
/**
 * 基于配置的角色基类
 */
abstract class Fixed implements Role{
	/**
	 * 配置文件创建工具
	 * @param mixed $name 角色对象或角色token
	 * @param mixed $res_token 资源对象或资源token
	 * @return string
	 */
	public static function opKey($name,$res_token){
		if (is_array($res_token)){
			if (count($res_token)>1) list($class,$args)=$res_token;
			else {list($class)=$res_token;$args=array();};
			$res_token=(new \ReflectionClass($class))->newInstanceArgs($args);
		}
		if ($res_token instanceof Res)$res_token =$res_token ->getToken();
		$res_token=strval($res_token);
		
		if (is_array($name)){
			if (count($name)>1) list($class,$args)=$name;
			else {list($class)=$name;$args=array();};
			$name=(new \ReflectionClass($class))->newInstanceArgs($args);
		}
		if ($name instanceof Role)$name=$name->getToken();
		$name=strval($name);
		return $name."@".$res_token;
	}
	protected $name;
	public function __construct($name=null){
		$this->name=$name;
	}
	/**
	 * 重写并返回配置
	 * @rewrite
	 * @return array
	 */
	protected static function config(){
	    //返回以下格式的数组
	    // 		array(
	    // 			'role-token@res-token'=>1<<0|1<<1|1<<2,
	    // 		);
	    return [];
	}
	/**
	 * @param Fixed[] $roles
	 * @param \LSYS\Rbac\Res[] $ress
	 * @return number[]
	 */
	public static function fetch(array $roles,array $ress){
	    $config=static::config();
	    if (!is_array($config))return [];
		$role_tokens=[];
		foreach ($roles as $role){
			assert($role instanceof Role);
			$role_tokens[]=$role->getToken();
		}
		if (count($role_tokens)==0)return [];
		$out=array();
		foreach ($role_tokens as $role_token){
			foreach ($ress as $res){
				$res_token=$res->getToken();
				$key=$role_token."@".$res_token;
				if (isset($config[$key]))$out[$res_token]=$config[$key];
			}
		}
		return $out;
	}
}


