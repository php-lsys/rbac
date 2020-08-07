<?php
namespace LSYS\Rbac;
/**
 * @method \LSYS\Rbac rbac($user=null)
 */
class DI extends \LSYS\DI{
    /**
     * @return static
     */
    public static function get(){
        $di=parent::get();
        !isset($di->rbac)&&$di->rbac(new \LSYS\DI\VirtualCallback(\LSYS\Rbac::class));
        return $di;
    }
}