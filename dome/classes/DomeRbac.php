<?php
use Visitor\DomeUser as VisitorUser;
use Visitor\DomeGuest;
use LSYS\Rbac\Visitor;
class DomeRbac extends LSYS\Rbac{
	public function __construct($vister){
		if (!$vister instanceof Visitor){
		    if (empty($vister)||$vister==0)$vister=new DomeGuest();
			else $vister=new VisitorUser($vister);
		}
		parent::__construct($vister);
	}
}