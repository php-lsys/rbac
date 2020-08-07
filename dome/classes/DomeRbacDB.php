<?php
trait DomeRbacDB{
	/**
	 * @param string $sql
	 * @return \Iterator||[]
	 */
	public static function dbFetchAll($sql){
	    return \LSYS\Database\DI::get()->db()->getConnect()->query( $sql);
	}
	/**
	 * @param mixed $value
	 * @return string
	 */
	public static function dbQuote($value){
	    return \LSYS\Database\DI::get()->db()->getConnect()->quote($value);
	}
	public static function dbExec($sql){
	    return \LSYS\Database\DI::get()->db()->getConnect()->query($sql);
	}
}