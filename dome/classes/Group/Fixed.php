<?php
namespace Group;
use LSYS\Config\File;
use LSYS\Rbac\Role;
abstract class Fixed extends \LSYS\Rbac\VisitorGroup\Fixed{
    public function __construct(){
        parent::__construct();
        $config=(array)(new File($this->config()))->get(__CLASS__);
        foreach ($config as $name){
            if (is_array($name)){
                if (count($name)>1) list($class,$args)=$name;
                else {list($class)=$name;$args=array();};
                $name=(new \ReflectionClass($class))->newInstanceArgs($args);
            }
            if ($name instanceof Role) $this->_role_group->add($name);
        }
    }
    abstract protected function config();
}