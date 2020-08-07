<?php
namespace LSYS\Rbac;
class OPGroup{
	protected $_list=[];
	private function _key(Res $res){
		return get_class($res).":".$res->getToken();
	}
	/**
	 * 添加操作功能到功能组
	 * @param Res $res
	 * @param OP $op
	 */
	public function add(Res $res,OP $op){
		//优化操作..相同资源.不同操作进行合并
		$key=$this->_key($res);
		if (isset($this->_list[$key]))$this->_list[$key][1][]=$op;
		else $this->_list[$key]=array($res,array($op));
	}
	/**
	 * 清除已添加的功能组
	 * @return \LSYS\Rbac\OPGroup
	 */
	public function clear(){
		$this->_list=[];
		return $this;
	}
	/**
	 * 得到操作组合中的资源列表
	 * @return Res[]
	 */
	public function groupRes(){
		$res=array();
		foreach ($this->_list as $v){
			list($res[])=$v;
		}
		return $res;
	}
	/**
	 * 根据资源得到对该资源所有操作
	 * @param Res $res
	 * @return OP[]
	 */
	public function groupOps(Res $res){
		$key=$this->_key($res);
		$op=[];
		if (!isset($this->_list[$key]))return $op;
		foreach ($this->_list[$key][1] as $v){
			$op[]=$v;
		}
		return $op;
	}
	/**
	 * 汇总指定资源需要的授权
	 * @return int
	 */
	public function groupOpValue(Res $res){
		//同一资源,可添加不同操作类,所以在此合并
		$key=$this->_key($res);
		$op=0;
		if (!isset($this->_list[$key]))return $op;
		foreach ($this->_list[$key][1] as $v){
			assert($v instanceof OP);
			$op|=$v->value();
		}
		return $op;
	}
}