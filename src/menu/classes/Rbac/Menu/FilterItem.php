<?php
namespace LSYS\Rbac\Menu;
use LSYS\Rbac\Res;
use LSYS\Rbac\Visitor;
use LSYS\Rbac\RoleGroup;
use LSYS\Rbac\VisitorGroup;
class FilterItem{
	/**
	 * @var Visitor
	 */
	protected $_vistor;
	/**
	 * @var MenuItem[]
	 */
	protected $_items=[];
	public function __construct(Visitor $vistor){
		$this->_vistor=$vistor;
	}
	/**
	 * 添加需验证的菜单
	 * 支持多维的数组,只处理item对象的数据
	 * @param mixed $item
	 * @return static
	 */
	public function addItem($item){
		if (is_array($item)){
			$this->_items=array_merge($this->_items,$item);
		}else if ($item instanceof MenuItem) $this->_items[]=$item;
		return $this;
	}
	/**
	 * 过滤出有权限操作的菜单
	 * @return array
	 */
	public function filter(){
		$items=$this->_items;
		$vister=$this->_vistor;
		$role_list=$vister->roleGroup();
		$vg=$vister->visitorGroup();
		if ($vg instanceof VisitorGroup) $role_list=RoleGroup::merge($vg->roleGroup(),$role_list);
		$access=array();
		$ress=$this->_groupRes($items);
		foreach ($role_list->group() as $v){
			$_access=$v::fetch($role_list->find($v),$ress);
			foreach ($_access as $res_token=>$op){
				if (!isset($access[$res_token]))$access[$res_token]=$op;
				else $access[$res_token]=$access[$res_token]&$op;
			}
		}
		$this->_removeBadItem($items,$access);
		return $items;
	}
	/**
	 * 过滤出有权限操作的菜单的数据
	 * @return []
	 */
	public function filterAsData(){
		$items=$this->filter();
		return $this->itemAsData($items);
	}
	/**
	 * 转换ITEM为数组
	 * @param array $items
	 * @return []
	 */
	private function itemAsData(array $items) {
	    foreach ($items as &$item){
	        if ($item instanceof MenuItem){
	            $item=$item->data();
	        }elseif(is_array($item)){
	            $item=$this->itemAsData($item);
	        }
	    }
	    return $items;
	}
	/**
	 * 汇总菜单中资源
	 * @param array $items
	 * @return Res[]
	 */
	protected function _groupRes(array $items){
		$ress=[];
		foreach ($items as $item){
		    if ($item instanceof MenuItem) $ress=array_merge($ress,$item->opGroup()->groupRes());
			else if (is_array($item)) $ress=array_merge($ress,$this->_groupRes($item));
		}
		return $ress;
	}
	/**
	 * 移除无权限菜单
	 * @param array $items
	 * @return Res[]
	 */
	protected function _removeBadItem(array &$items,$access){
		foreach ($items as $k=>&$item){
		    if ($item instanceof MenuItem){
				$opgroup=$item->opGroup();
				foreach ($opgroup->groupRes() as $res){
					$_op=$opgroup->groupOpValue($res);
					$vister_op=isset($access[$res->getToken()])?intval($access[$res->getToken()]):0;
					if ($_op>0&&($_op&$vister_op)!=$_op){
						unset($items[$k]);
						break ;
					}
				}
			}else if (is_array($item))$this->_removeBadItem($item,$access);
		}
	}
}