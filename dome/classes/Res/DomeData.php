<?php
namespace Res;
use LSYS\Rbac\Res;
class DomeData implements Res{
    protected $_id;
    public function __construct($id){
        $this->_id=$id;
    }
	public function __toString(){
		return "数据资源-{$this->_id}";
	}
	public function getToken(){
	    return implode(",", ["data",$this->_id]);
	}
}