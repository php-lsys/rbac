<?php
use Menu\TestMenu1;
use Menu\TestMenu2;
use LSYS\Rbac\Menu\FilterItem;
use LSYS\Rbac\Menu\MenuItem;
use Res\DomeTestRes;
use OP\DomeTestOP;

$loader=include_once __DIR__."/bootstarp.php";
$loader->setPsr4("",array("classes"));
//创建菜单数据方式1:
//----------------------------------------------------------------------------------------
//把菜单数据放入子类中
$b=new TestMenu1();
$c=new TestMenu2();
$arr=[ 'b'=>$b->getMenus(),'c'=>$c->getMenus()];
// 直接对菜单中的元素进行权限验证
// $r=$b->check(new DomeRbac(1), TestMenu1::HOME);
// if (!$r->status())var_dump($r->getMessage());
// print_r($r);
// exit;
//----------------------------------------------------------------------------------------
 
//创建菜单数据方式2:
//----------------------------------------------------------------------------------------
//不建立子类,直接自己生产数组
$arr=[
    MenuItem::factory([new DomeTestRes(),new DomeTestOP()],array("text"=>"显示文字","url"=>"http://baidu.com")),
    MenuItem::factory([new DomeTestRes(),new DomeTestOP()],array("text"=>"显示文字1","url"=>"http://baidu.com"))
];
//----------------------------------------------------------------------------------------

//进行菜单过滤
$vister=new Visitor\DomeGuest();
// $vister=new Visitor\User(1);
$arr=(new FilterItem($vister))->addItem($arr)->filterAsData();
print_r($arr);

