<?php
namespace GDO\Language;
use GDO\Core\GDO;
use GDO\DB\GDT_Char;
use GDO\Core\GDT_Template;
use GDO\DB\Cache;
/**
 * Language table
 * @author gizmore
 * @version 6.05
 * @since 3.00
 */
class GDO_Language extends GDO
{
    public function gdoColumns()
    {
        return array(
            GDT_Char::make('lang_iso')->primary()->size(2),
        );
    }
    
    public function getISO() { return $this->getVar('lang_iso'); }
    public function displayName() { return t('lang_'.$this->getISO()); }
    public function displayNameISO($iso) { return tiso($iso, 'lang_'.$this->getISO()); }
    public function renderCell()
    {
        return GDT_Template::php('Language', 'cell/language.php', ['language'=>$this]);
    }
    public function renderChoice()
    {
        return GDT_Template::php('Language', 'choice/language.php', ['language'=>$this]);
    }
    
    /**
     * Get a language by ISO or return a stub object with name "Unknown".
     * @param string $iso
     * @return self
     */
    public static function getByISOOrUnknown($iso=null)
    {
        if ( ($iso === null) || (!($language = self::getById($iso))) )
        {
            $language = self::blank(['lang_iso'=>'zz']);
        }
        return $language;
    }
    
    /**
     * @return self[]
     */
    public function allSupported()
    {
        return Module_Language::instance()->cfgSupported();
    }
    
    /**
     * @return self[]
     */
    public function all()
    {
        if (false === ($cache = Cache::get('gdo_languages')))
        {
            $cache = self::table()->select('*')->exec()->fetchAllArray2dObject();
            Cache::set('gdo_languages', $cache);
        }
        return $cache;
    }
}