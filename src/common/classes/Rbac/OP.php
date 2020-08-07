<?php
namespace LSYS\Rbac;
abstract class OP{
	protected $_op=[];
	/**
	 * 资源操作基类
	 * 多个权限用用数组
	 * @param int|array $op 访问该资源需要权限
	 */
	public function __construct($op){
		//传数组,目的为需要多个操作权限情况
		if (!is_array($op))$op=[$op];
		$this->_op=$op;
	}
	/**
	 * 得到当前操作的描述
	 * @return string
	 */
	public function detail($op=null){
		$out=static::details();
		$op=$op==null?$this->_op:[$op];
		$str=[];
		foreach ($op as $v){
			if (isset($out[$v]))$str[]=$out[$v];
			else $str[]=$v;
		}
		return implode(",", $str);
	}
	/**
	 * 当前授权的值
	 * @return int
	 */
	public function value(){
		$op=0;
		foreach ($this->_op as $v)$op=$op|$v;
		return $op;
	}
	/**
	 * 当前授权的值列表
	 * @return int[]
	 */
	public function values(){
		return $this->_op;
	}
	/**
	 * 获取操作详细
	 * @override
	 * @return array
	 */
	public static function details(){
		return [];
	}
}