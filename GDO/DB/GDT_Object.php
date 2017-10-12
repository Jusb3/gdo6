<?php
namespace GDO\DB;
use GDO\Core\GDT_Template;
use GDO\Core\WithCompletion;

class GDT_Object extends GDT_UInt
{
    use WithObject;
    use WithCompletion;
    
    public function renderJSON()
    {
        $gdo = $this->getValue();
        return array_merge(parent::renderJSON(), array(
            'selected' => ($gdo ? array(
                'id' => $gdo->getID(),
                'display' => $gdo->displayName(),
            ) : null),
            'completionHref' => $this->completionHref,
        ));
    }

    public function renderCell()
    {
    	if ($obj = $this->getValue())
    	{
    		return $obj->renderCell();
    	}
    	return $this->getValue();
    }
    
    public function renderChoice()
    {
        if ($obj = $this->gdo)
        {
            return $obj->renderChoice();
        }
        return $this->getValue();
    }
    
    public function renderForm()
    {
        if ($this->completionHref)
        {
            return GDT_Template::php('DB', 'form/object_completion.php', ['field'=>$this]);
        }
        else
        {
            return GDT_Template::php('DB', 'form/object.php', ['field'=>$this]);
        }
    }
    
    public function renderFilter()
    {
    	return GDT_Template::php('DB', 'filter/object.php', ['field'=>$this]);
    }
}