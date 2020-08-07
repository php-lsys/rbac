<?php
return array(
	//示例配置.未引入
	"vg_role"=>array(//组关联角色数组
	// 		Member::class=>array(
			//每一个记录为一个角色对象
			// 			new LSYS\Rbac\Role\Fixed("bbb"),
			// 			[LSYS\Rbac\Role\Fixed::class,["bbb"]],
			// 		),
	),
	"op"=>array(//角色配置权限数组
			//KEY为 LSYS\Rbac\Role\Fixed::opKey 生成 VALUE为权限
			// 		LSYS\Rbac\Role\Fixed::opKey([Role\Fixed::class,["bbb"]],[Res\TestRes::class])=>1|3,
			// 		LSYS\Rbac\Role\Fixed::opKey(new Role\Fixed("bbb"),new Res\TestRes())=>CURD::DELETE|CURD::INSERT,
	),
);