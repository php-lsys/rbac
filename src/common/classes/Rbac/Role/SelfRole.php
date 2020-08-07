<?php
namespace LSYS\Rbac\Role;
interface SelfRole{
    /**
     * @param mixed $uid
     * @return bool
     */
    public function equals($uid);
}