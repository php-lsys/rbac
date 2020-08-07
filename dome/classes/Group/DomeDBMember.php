<?php
namespace Group;
use Role\DomeFixed;
use LSYS\Rbac\RoleGroup;
use LSYS\Rbac\Role;
use LSYS\Rbac\VisitorGroup;
class DomeDBMember implements VisitorGroup{
    /**
     * @var RoleGroup
     */
    protected $_role_group;
    public function __construct(){
        $this->_role_group=new RoleGroup();
        $table='role_user';
        $where="group_name='member'";
        if (empty($where))return ;
        $sql="select * from {$table} where {$where}";
        foreach (\LSYS\Database\DI::get()->db()->getConnect()->query($sql) as $v){
            //解析角色字符串成角色对象
            if (substr($v['role_str'], 0,2)=='db'){
                $role= new \Role\DomeData(substr($v['role_str'], 3));
            }elseif (substr($v['role_str'], 0,5)=='fixed'){
                $role= new DomeFixed(substr($v['role_str'], 6));
            }
            if (!$role instanceof Role)continue;
            $this->_role_group->add($role);
        }
        $this->_role_group->add(new DomeFixed("bbb"));
    }
    /**
     * @return RoleGroup
     */
    public function roleGroup(){
        return $this->_role_group;
    }
	public function groupName(){
		return "member";
	}
}