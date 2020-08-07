<?php
use Group\DomeMember AS Member;
use OP\DomeTestOP as TestOP;
use OP\DomeCURD;
return array(
	"vg_role"=>array(
		Member::class=>array(
			new Role\DomeFixed("bbb"),
		    [Role\DomeFixed::class,["bbbddd"]],
		),
	),
	"op"=>array(
	    LSYS\Rbac\Role\Fixed::opKey([Role\DomeFixed::class,["bbb"]],[Res\DomeTestRes::class])=>TestOP::view,
	    LSYS\Rbac\Role\Fixed::opKey(new Role\DomeFixed("bbb"),new Res\DomeTestRes())=>DomeCURD::DELETE|DomeCURD::INSERT,
	),
);

