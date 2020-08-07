<?php
namespace OP;
use LSYS\Rbac\OP;
use function LSYS\RBAC\__;
/**
 * 常用资源操作基类
 */
class DomeCURD extends OP{
	//查看 插入 删除	 更新
	//1    1    1    1
	/**
	 * 可查看资源
	 * @var int
	 */
	const SELECT=1;
	/**
	 * 可插入资源
	 * @var int
	 */
	const INSERT=1|1<<1;
	/**
	 * 可删除资源
	 * @var int
	 */
	const DELETE=1|1<<2;
	/**
	 * 可修改资源
	 * @var int
	 */
	const UPDATE=1|1<<3;
	/**
	 * {@inheritDoc}
	 * @see \LSYS\Rbac\OP::details()
	 */
	public static function details(){
		return array(
			self::SELECT=>__("rbac select"),
			self::INSERT=>__("rbac insert"),
			self::UPDATE=>__("rbac update"),
			self::DELETE=>__("rbac delete"),
		);
	}
}