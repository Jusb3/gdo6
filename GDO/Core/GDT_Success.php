<?php
namespace GDO\Core;

use GDO\UI\GDT_Panel;

/**
 * A success message, the pedant to GDT_Error.
 * 
 * @author gizmore
 * @version 6.10
 * @since 6.00
 * @see GDT_Error
 */
class GDT_Success extends GDT_Panel
{
	public static function responseWith($key, array $args=null, $code=200, $log=true)
	{
		return GDT_Response::makeWith(self::with($key, $args, $code, $log));
	}
	
	public static function with($key, array $args=null, $code=200, $log=true)
	{
		if ($log)
		{
			Logger::logMessage(tiso('en', $key, $args));
		}
		return self::make()->text($key, $args);
	}
	
	##############
	### Render ###
	##############
	public function renderCell() { return GDT_Template::php('Core', 'cell/success.php', ['field' => $this]); }
	
}
