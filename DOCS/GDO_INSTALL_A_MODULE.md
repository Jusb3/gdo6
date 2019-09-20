# Install a GDO6 module

This document describes the process of installing a single gdo6 module for a productive environment.

Each gdo6 module is cloned via git into the gdo6/GDO/ folder.

Do not forget a --recursive when you clone a module, as sometimes 3rd party repositories are cloned.

The core UI module for example needs htmlpurifier.
 

## Clone a module repository

Switch to the module folder and clone the module.

It is important that you clone it as the right module Name.
E.g: gdo6-jquery as JQuery

    cd gdo6/GDO
    git clone --recursive https://github.com/gizmore/gdo6-jquery JQuery
    
## Install javascript dependencies

Switch to the gdo root folder and invoke helpers. These install all javascript dependencies in their latest appropiate version.

    cd gdo6
    ./gdo_bower.sh
    ./gdo_yarn.sh
   
## Install the module via gdo6 admin panel

Open the gdo6 admin panel and install the module. In recovery cases you can try the install wizard.

That's it!