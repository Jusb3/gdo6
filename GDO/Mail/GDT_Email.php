<?php
namespace GDO\Mail;
use GDO\DB\GDT_String;
use GDO\Core\GDT_Template;

class GDT_Email extends GDT_String
{
    public $pattern = "/^[^@]+@[^@]+$/i";
    
    public function defaultLabel() { return $this->label('email'); }
    
    public function renderForm() { return GDT_Template::php('Mail', 'form/email.php', ['field' => $this]); }
    public function renderCell() { return GDT_Template::php('Mail', 'cell/email.php', ['field' => $this]); }
}