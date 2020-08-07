<?php
namespace Role;
use LSYS\Rbac\Role;
use LSYS\Rbac\Res;
use LSYS\Rbac\OP;
class DomeData implements Role{
    protected $_id;
    public function __construct($id){
        $this->_id=$id;
    }
    /**
     * @param Role[] $roles
     * @param \LSYS\Rbac\Res[] $ress
     * @return number[]
     */
    public static function fetch(array $roles,array $ress){
        $role_tokens=[];
        foreach ($roles as $role){
            assert($role instanceof Role);
            $role_tokens[]=$role->getToken();
        }
        if (count($role_tokens)==0)return [];
        
        $table=static::dbTable();
        
        $role_sql='role_token in '.static::dbQuote($role_tokens);
        
        $res_arr=[];
        
        //相同资源.不同操作合并
        //对某个资源 执行某项操作
        foreach ($ress as $v){
            $res_arr[]=$v->getToken();
        }
        
        $res_sql='res_token in '.static::dbQuote($res_arr);
        //	角色[string]-	操作[int32]-		资源[string]
        //	role_token 		op_token 		res_token
        $sql="select bit_or(op_token) as op_token,res_token from {$table} where {$role_sql} and {$res_sql} group by res_token";//角色功能列表
        $out=array();
        foreach (static::dbFetchAll($sql) as $v){
            $out[$v['res_token']]=$v['op_token'];
        }
        return $out;
    }
    /**
     * 给指定角色设置权限
     * @param DomeData $role 角色
     * @param Res $res 资源
     * @param OP $op 操作,传NULL删除权限
     * @return int 影响记录数
     */
    public static function opSet(DomeData $role,Res $res,OP $op=null){
        return self::opSets(func_get_args());
    }
    /**
     * 给指定角色设置权限[批量]
     * $ops => [Data $role,Res $res,OP $op=null]
     * $ops => [[Data $role,Res $res,OP $op=null]]
     * @param array $ops 参考 op_set 参数
     * @return number
     */
    public static function opSets(array $ops){
        $_ops=$ival=$uval=$dval=$where_val=[];
        foreach (func_get_args() as $ops){
            if (isset($ops[0])&&is_array($ops[0])){
                foreach ($ops as $v)$_ops[]=$v;
            }else $_ops[]=$ops;
        }
        foreach ($_ops as $v){
            if (count($v)>=3){
                list($role,$res,$op)=$v;
            }else{
                list($role,$res)=$v;
                $op=null;
            }
            assert($role instanceof DomeData);
            assert($res instanceof Res);
            $role_token=strval($role->getToken());
            $res_token=strval($res->getToken());
            if ($op instanceof OP)$op=$op->value();
            $op_token=intval($op);
            $_token=[$role_token,$res_token];
            foreach ($ival as $v_){
                if ($v_[0]==$_token){
                    $v_[1]=$v_[1]|$op_token;
                    unset($op_token);
                    break;
                }
            }
            if (isset($op_token)){
                $role_token=static::dbQuote($role_token);
                $res_token=static::dbQuote($res_token);
                $where_val[]="(role_token={$role_token} and res_token={$res_token})";
                $ival[]=[$_token,$op_token];
            }
        }
        foreach ($ival as $k=>$v){
            if (!intval($v[1])){
                $dval[]=$v[0];
                unset($ival[$k]);
            }
        }
        $table=static::dbTable();
        $where_val=implode(" or ", $where_val);
        $sql="SELECT role_token,res_token,op_token FROM {$table} where {$where_val}";
        foreach (static::dbFetchAll($sql) as $v){
            $v=array_values($v);
            $op=array_pop($v);
            foreach ($ival as $_k=>$_v){
                if($v==$_v[0]){
                    if ($op!=$_v[1])$uval[]=$_v;
                    unset($ival[$_k]);
                    break;
                }
            }
        }
        $out=0;
        if (count($ival)>0){
            $val=[];
            foreach ($ival as $v){
                $v[0]=array_map(array(get_called_class(),"dbQuote"), $v[0]);
                $v[0]=implode(",", $v[0]);
                $val[]="({$v[0]},{$v[1]})";
            }
            $val=implode(",", $val);
            $sql="INSERT INTO {$table} (role_token, res_token, op_token)VALUES{$val}";
            $out=static::dbExec($sql);
        }
        if (count($uval)>0){
            $val=[];
            foreach ($uval as $v){
                $v[0]=array_map(array(get_called_class(),"dbQuote"), $v[0]);
                list($role_token,$res_token)=$v[0];
                $sql="UPDATE {$table}
					SET op_token={$v[1]}
					WHERE role_token={$role_token} and res_token={$res_token};";
                $out+=static::dbExec($sql);
            }
        }
        if (count($dval)>0){
            $val=[];
            foreach ($dval as $v){
                $v=array_map(array(get_called_class(),"dbQuote"), $v);
                list($role_token,$res_token)=$v;
                $val[]="(role_token={$role_token} and res_token={$res_token})";
            }
            $val=implode(" or ", $val);
            $sql="DELETE FROM {$table} where {$val}";
            $out+=static::dbExec($sql);
        }
        return $out;
    }
	/**
	 * {@inheritDoc}
	 * @see \LSYS\Rbac\Role::getToken()
	 */
	public function getToken(){
		return "db-".$this->_id;
	}
	/**
	 * @param mixed $value
	 * @return string
	 */
	private static function dbTable(){
	    return "role_fn";
	}
	/**
	 * @param string $sql
	 * @return \Iterator||[]
	 */
	private static function dbFetchAll($sql){
	    return \LSYS\Database\DI::get()->db()->getConnect()->query( $sql);
	}
	private static function dbQuote($value){
	    return \LSYS\Database\DI::get()->db()->getConnect()->quote($value);
	}
	private static function dbExec($sql){
	    return \LSYS\Database\DI::get()->db()->getConnect()->query($sql);
	}
}