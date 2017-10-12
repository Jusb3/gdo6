<?php
namespace GDO\Country;
use GDO\Core\WithCompletion;
use GDO\DB\GDT_ObjectSelect;
use GDO\Core\GDT_Template;
/**
 * Country selection field.
 * @author gizmore
 * @since 6.00
 * @version 6.05
 */
final class GDT_Country extends GDT_ObjectSelect
{
    use WithCompletion;
    
    public function __construct()
    {
        $this->table(GDO_Country::table());
        $this->min = $this->max = 2;
    }
    
    public function withCompletion()
    {
        return $this->completionHref(href('Country', 'Completion'));
    }
    
    public function defaultLabel() { return $this->label('country'); }
    
    public function renderJSON()
    {
        return array_merge(parent::renderJSON(), array(
            'completionHref' => $this->completionHref,
        ));
    }
    
    public function renderCell()
    {
        return GDT_Template::php('Country', 'cell/country.php', ['field'=>$this]);
    }
}