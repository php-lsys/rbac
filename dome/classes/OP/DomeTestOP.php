<?php
namespace OP;
use LSYS\Rbac\OP;
class DomeTestOP extends OP{
	/**
	 * 可查看资源
	 * @var int
	 */
	const view=1;
	public function __construct($op=1){
		parent::__construct($op);
	}
	/**
	 * {@inheritDoc}
	 * @see \LSYS\Rbac\OP::detail()
	 */
	public static function details(){
		return array(
			self::view=>"查看",
		);
	}
}