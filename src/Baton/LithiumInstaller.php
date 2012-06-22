<?php
namespace Baton;

class LithiumInstaller extends BaseInstaller
{

    protected $locations = array(
        'app'           => '',
        'library'       => 'libraries/{name}/',
        'controller'    => 'controllers/',
        'extension'     => 'extensions/{name}/',
        'model'         => 'models/',
    );

}
