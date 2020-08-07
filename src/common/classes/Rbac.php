<?php
namespace LSYS;
use LSYS\Rbac\Res;
use LSYS\Rbac\Visitor;
use LSYS\Rbac\OP;
use LSYS\Rbac\Result;
use LSYS\Rbac\OPGroup;
use LSYS\Rbac\RoleGroup;
use LSYS\Rbac\VisitorGroup;
use LSYS\Rbac\Res\SelfRes;
use LSYS\Rbac\Role\SelfRole;

class Rbac{
	/**
	 * @var Visitor
	 */
	protected $_vistor;
	/**
	 * @var OPGroup
	 */
	protected $_opgroup;
	public function __construct(Visitor $vistor){
		$this->_vistor=$vistor;
		$this->_opgroup=new OPGroup();
	}
	/**
	 * 添加需验证的资源操作
	 * @param Res $res 资源对象
	 * @param OP $op 对资源操作对象
	 * @return \LSYS\Rbac
	 */
	public function addOp(Res $res,OP $op){
		$this->_opgroup->add($res, $op);
		return $this;
	}
	/**
	 * 添加需验证的资源操作[批量]
	 * @param array $ops [Res $res,OP $op] 参考add_op注释
	 * @return \LSYS\Rbac
	 */
	public function addOps(array $ops){
		foreach (func_get_args() as $ops){
			if (!isset($ops[0]))continue;//添加空数组方式报错...
			if (isset($ops[0])&&is_array($ops[0])){
				foreach ($ops as $v){
					assert($v[0] instanceof Res);
					assert($v[1] instanceof OP);
					$this->_opgroup->add($v[0], $v[1]);
				}
			}else{
				assert($ops[0] instanceof Res);
				assert($ops[1] instanceof OP);
				$this->_opgroup->add($ops[0], $ops[1]);
			}
		}
		return $this;
	}
	/**
	 * 清除已添加需验证的资源操作
	 * @return \LSYS\Rbac
	 */
	public function clearOp(){
		$this->_opgroup->clear();
		return $this;
	}
	/**
	 * 进行权限检查
	 * ->check();
	 * @return Result
	 */
	public function check(){
// 		print_r($vister->visitorGroup()->roleGroup());
// 		print_r($vister->roleGroup());
// 		exit;
		$opgroup=$this->_opgroup;
		$vister=$this->_vistor;
		$role_list=$vister->roleGroup();
		$vg=$vister->visitorGroup();
		if ($vg instanceof VisitorGroup) $role_list=RoleGroup::merge($vg->roleGroup(),$role_list);
		$access=array();
		$ress=$opgroup->groupRes();
		foreach ($role_list->group() as $v){
		    $roles=$role_list->find($v);
		    foreach ($roles as $role){
		        if(!$role instanceof SelfRole)continue;
		        foreach ($ress as $k=>$rv){
		            if (!$rv instanceof SelfRes||!$role->equals($rv->user()))continue;
		            unset($ress[$k]);
	                $access[$v->getToken()]=~0;
		        }
		    }
		    if (count($ress)>0) {
		        $_access=$v::fetch($roles,$ress);
		        foreach ($_access as $res_token=>$op){
		            if (!isset($access[$res_token]))$access[$res_token]=$op;
		            else $access[$res_token]|=$op;
		        }
		    }
		}
		foreach ($ress as $res){//遍历添加资源进行权限检测
			$_op=$opgroup->groupOpValue($res);
			$vister_op=isset($access[$res->getToken()])?intval($access[$res->getToken()]):0;//得到每个资源的访问权限
			if ($_op>0&&($_op&$vister_op)!=$_op){
				//检测失败..
				return new Result($opgroup,$res,$vister_op);
			}
		}
		return new Result();
	}
}

//用户->资源
//V1 
//V2
//V3
//A -
//B -
//用户[A模块用户,B模块用户]
//模块A-[开放功能1,功能1,功能2] 模块B-[开放功能1,功能1,功能2]
//游客角色[]
//资源


//访客	[查找]->	前台|后台=公共角色
//		[查找]->	独有角色

//汇总角色	[检测]->	功能{资源[操作决定]}

//功能	res+op