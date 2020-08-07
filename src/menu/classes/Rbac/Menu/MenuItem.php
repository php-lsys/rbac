<?php
namespace LSYS\Rbac\Menu;
use LSYS\Rbac\OPGroup;
use LSYS\Rbac\Res;
use LSYS\Rbac\OP;
class MenuItem{
	protected $_opgroup;
	protected $_data;
	/**
	 * 创建菜单工具
	 * @param mixed $data
	 * @param array $opgroup
	 * @return static
	 */
	public static function factory(array $opgroup,$data){
	    $ops=new OPGroup();
	    if (isset($opgroup[0])&&is_object($opgroup[0])){
	        list($res,$op)=$opgroup;
	        assert($res instanceof Res);
	        assert($op instanceof OP);
	        $ops->add($res, $op);
	    }elseif (isset($opgroup[0])&&is_array($opgroup[0])) foreach ($opgroup as $v){
	        list($res,$op)=$v;
	        assert($res instanceof Res);
	        assert($op instanceof OP);
	        $ops->add($res, $op);
	    }
	    return new static($ops,$data);
	}
	/**
	 * 菜单元素
	 * @param OPGroup $opgroup
	 * @param mixed $data
	 */
	public function __construct(OPGroup $opgroup,&$data=null){
		$this->_opgroup=$opgroup;
		$this->_data=$data;
	}
	/**
	 * 访问此菜单需要的权限
	 * @return \LSYS\Rbac\OPGroup
	 */
	public function opGroup(){
		return $this->_opgroup;
	}
	/**
	 * 附带数据
	 * @return string
	 */
	public function data(){
		return $this->_data;
	}
}