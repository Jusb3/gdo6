<?php
namespace GDO\Install;
use GDO\Core\GDO_Module;
/**
 * Module that features the installer.
 * The entry point is in install/wizard.php
 * 
 * Provides the install theme to style the install wizard.
 * 
 * @author gizmore
 * @since 6.00
 * @version 6.05
 */
class Module_Install extends GDO_Module
{
	public function isInstallable() { return false; }

	public function onLoadLanguage() { $this->loadLanguage('lang/install'); }
	public function defaultEnabled() { return false; }
	public function getTheme() { return 'install'; }
}
