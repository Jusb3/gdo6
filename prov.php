<?php

use GDO\File\Filewalker;
use GDO\Util\Common;

include "GDO6.php";

Filewalker::traverse("GDO", null, false, function($entry, $fullpath) {
   if (is_dir('GDO/'.$entry."/.git"))
   {
       $c = file_get_contents('GDO/'.$entry."/.git/config");
       $c = Common::regex('#/gizmore/([-_a-z0-9]+)#m', $c);
       echo "'".$entry."' => '$c',\n";
   }
},  0);