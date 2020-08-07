<?php
namespace LSYS\Rbac;
use LSYS\Rbac;
use LSYS\Rbac\Menu\MenuItem;
/**
 * 基本菜单基类
 * 如果手动生成菜单,可不需要创建该类子类
 */
abstract class Menu{
    /**
     * @var array
     */
    private $rules=[];
	/**
	 * RBAC check封装,方便使用
	 * @param Rbac $rbac
	 * @param string $key
	 * @return \LSYS\Rbac\Result
	 */
	public function check(Rbac $rbac,$key){
		return $rbac->addOps($this->getOps($key))->check();
	}
	/**
	 * 添加菜单规则
	 * @param string $key
	 * @param array $rule
	 * @param mixed $data
	 * @return static
	 */
	public function add($key,array $rule,$data=null){
		$this->rules[$key]=array($rule,$data);
		return $this;
	}
	/**
	 * 获取操作权限数组
	 * @param string $key
	 * @return mixed
	 */
	public function getOps($key){
		if (isset($this->rules[$key]))return $this->rules[$key][0];
		else [];
	}
	/**
	 * 根据添加的菜单数据生成菜单数组
	 * @return MenuItem[]
	 */
	public function getMenus(){
		$item=array();
		foreach ($this->rules as $v){
			list($ops,$data)=$v;
			$item[]=MenuItem::factory($ops,$data);
		}
		return $item;
	}
}