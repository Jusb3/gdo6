<?php
namespace GDO\Table;
use GDO\DB\GDT_UInt;
/**
 * Database Column that handles sorting.
 * @author gizmore
 * @version 6.05
 * @since 6.00
 */
class GDT_Sorting extends GDT_UInt
{
	protected function __construct()
	{
		$this->min = 0;
		$this->max = 65535;
		$this->bytes = 2;
		$this->label('sorting');
	}
	
	public function gdoAfterCreate()
	{
		$this->gdo->saveVar($this->name, $this->gdo->getID());
	}
}
