<?php
namespace LSYS\Rbac;
use function LSYS\Rbac\__;

class Result{
	/**
	 * @var Res
	 */
	protected $_res;
	/**
	 * @var OPGroup
	 */
	protected $_op_group;
	/**
	 * 当前授权
	 * @var int
	 */
	protected $_vister_op;
	public function __construct(OPGroup $op_group=null,Res $fail_res=NULL,$vister_op=0){
		$this->_res=$fail_res;
		$this->_op_group=$op_group;
		$this->_vister_op=$vister_op;
	}
	/**
	 * 检测权限失败的资源
	 * @return \LSYS\Rbac\Res
	 */
	public function failRes(){
		return $this->_res;
	}
	/**
	 * 检测的权限组
	 * @return \LSYS\Rbac\OPGroup
	 */
	public function opGroup(){
		return $this->_op_group;
	}
	/**
	 * 得到不匹配的位数
	 * @return boolean
	 */
	public function getCode(){
		$op=$this->_op_group->groupOpValue($this->_res);
		return $op&~($op&$this->_vister_op);
	}
	/**
	 * 得到消息
	 * @return string
	 */
	public function getMessage(){
		if ($this->_res==null) return __("rbac is success");//授权成功
		else{
			$opstr=[];//默认操作字符
			foreach ($this->_op_group->groupOps($this->_res) as $v){
				foreach ($v->values() as $_op){
					if($_op>0&&($_op&$this->_vister_op)!=$_op) $opstr[]=$v->detail($_op);
				}
			}
			if (count($opstr))$opstr=__("rbac can't :op",array(":op"=>implode(",", $opstr)));//无法:op
			else $opstr=__("rbac not access");//无权限访问
			return $opstr.strval($this->_res);
		}
	}
	/**
	 * 校验的token
	 * @return string
	 */
	public function getToken(){
	    return $this->_res->getToken();
	}
	/**
	 * 是否成功授权
	 * @return boolean
	 */
	public function status(){
		return $this->_res==null;
	}
}