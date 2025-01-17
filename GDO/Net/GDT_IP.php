<?php
namespace GDO\Net;

use GDO\DB\GDT_String;

/**
 * IP column and rendering.
 * Current IP is assigned at the very bottom.
 * @author gizmore
 * @since 6.00
 * @version 6.05
 */
final class GDT_IP extends GDT_String
{
	###############
	### IP Util ###
	###############
	public static $CURRENT = null; # for connections like websocket too!
	public static function current() { return self::$CURRENT; }
	
	public static function isLocal( $ip=null)
	{
		$ip = $ip ? $ip : self::$CURRENT;
		return ($ip === '::1') || (substr($ip, 0, 4) === '127.');
	}
	
	public function useCurrent($useCurrent=true)
	{
	    if (!$useCurrent)
	    {
	        return $this->initial(null);
	    }
	    else
	    {
    	    return $this->initial(self::current());
	    }
	}

	##############
	### String ###
	##############
	public $min = 3;
	public $max = 45;
	public $encoding = self::ASCII;
	public $caseSensitive = true;
	public $pattern = "/^[.:0-9a-f]{3,45}$/";
	public $writable = false;
	public $editable = false;
	public $icon = 'url';
	
	public function defaultLabel() { return $this->label('ip'); }
	
	/**
	 * Uppercase IPv6 to speed up DB lookups.
	 * {@inheritDoc}
	 * @see \GDO\DB\GDT_String::getVar()
	 */
	public function getVar()
	{
		return strtoupper(parent::getVar());
	}
}

# Assign current IP.
GDT_IP::$CURRENT = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1';
