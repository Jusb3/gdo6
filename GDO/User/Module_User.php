<?php
namespace GDO\User;

use GDO\Core\GDO;
use GDO\Core\GDO_Module;
use GDO\Session\GDO_Session;

/**
 * GDO_User related types and plugins.
 * @author gizmore
 * @version 6.10
 * @since 3.00
 */
final class Module_User extends GDO_Module
{
	public $module_priority = 3;
	
	public function isCoreModule() { return true; }
	public function onInstall() { OnInstall::onInstall(); }
	public function onLoadLanguage() { $this->loadLanguage('lang/user'); }
	public function href_administrate_module() { return href('User', 'Admin'); }

	public function getClasses()
	{
	    $classes = array(
			GDO_User::class,
			GDO_UserPermission::class,
			GDO_UserSetting::class,
			GDO_UserSettingBlob::class,
		);
	    if (is_a(GDO_Session::class, GDO::class, true))
	    {
	        $classes[] = GDO_Session::class;
	    }
	    return $classes;
	}
	
}
