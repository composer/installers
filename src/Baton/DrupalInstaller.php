<?php
namespace Baton;

class DrupalInstaller extends BaseInstaller
{

    protected $locations = array(
        'module'    => 'sites/all/modules/{name}/',
        'theme'     => 'sites/all/themes/{name}/',
    );

}
