<?php
namespace Res;
use LSYS\Rbac\Res;
class DomeUserData implements Res{
    protected $_id;
    protected $_user;
    public function __construct($user,$id){
        $this->_user=$user;
        $this->_id=$id;
    }
	public function __toString(){
		return "用户资源-{$this->_user}:{$this->_id}";
	}
	public function getToken(){
	    return implode(",",["user",$this->_user,$this->_id]);
	}
}