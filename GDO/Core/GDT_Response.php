<?php
namespace GDO\Core;
use GDO\UI\GDT_HTML;

/**
 * The response class renders fields according to the request content-type.
 * You can control the content type with the &fmt=json|html GET parameter.
 * 
 * @author gizmore
 * @version 6.05
 */
class GDT_Response extends GDT
{
	use WithFields;
	
	public static $CODE = 200;
	
	public static function globalError() { return self::$CODE >= 400; }
	
	####################
	### JSON Details ###
	####################
	
	##################
	### Error code ###
	##################
	public $code = 200;
	public function code($code) { $this->code = $code; return $this; }
	public function errorCode($code=405) { return $this->code($code); }
	public function isError()
	{
		if ($this->code >= 400)
		{
			return true;
		}
		foreach ($this->fields as $gdt)
		{
			if ($gdt->hasError())
			{
				return true;
			}
		}
		return false;
	}
	
	###############
	### Factory ###
	###############
	/**
	 * Create a response from plain html by adding a GDT_HTML field containing your html.
	 * @param string $html
	 * @return \GDO\Core\GDT_Response
	 */
	public static function makeWithHTML($html)
	{
		return self::make()->addHTML($html);
	}
	
	##############
	### Render ###
	##############
	public function render()
	{
	    return $this->renderCell();
	}
	
	public function renderCell()
	{
		switch (Application::instance()->getFormat())
		{
			case Application::HTML: return $this->renderHTML();
			case Application::JSON: return $this->renderJSON();
		}
	}
	
	public function renderHTML()
	{
	    return $this->_renderHTMLRec($this);
	}
	
	private function _renderHTMLRec(GDT $gdt)
	{
	    $html = '';
	    if ($fields = $gdt->getFields())
	    {
    	    foreach ($fields as $field)
    	    {
    	        $html .= $field->render();
    	        if ($field instanceof GDT_Response)
    	        {
        	        $html .= $this->_renderHTMLRec($field); # #XXX: only responses recursively.
    	        }
    	    }
	    }
	    return $html;
	}
	
	public function renderJSON()
	{
		return array(
			'code' => $this->code,
			'data' => $this->renderJSONFields(),
		);
	}
	
	private function renderJSONFields()
	{
		$back = [];
		foreach ($this->getFieldsRec() as $field)
		{
			if ($json = $field->renderJSON())
			{
				$back[$field->name] = $json;
			}
		}
		return $back;
	}
	
	################
	### Chaining ###
	################
	public function add(GDT_Response $response=null)
	{
	    if ($response && $response->code != 200)
	    {
	        self::$CODE = $this->code = $response->code;
	    }
		return $response ? $this->addFields($response->getFields()) : $this;
	}
	
	public function addHTML($html)
	{
		return $html ? $this->addField(GDT_HTML::withHTML($html)) : $this;
	}
	
}
