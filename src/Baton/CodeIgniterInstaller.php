<?php
namespace Baton;

use Composer\Package\BasePackage;

class CodeIgniterInstaller extends BaseInstaller
{

    protected $locations = array(
        'app'           => '/',
        'library'       => '/libraries/{name}/',
        'controller'    => '/controllers/',
        'third-party'   => '/third-party/{name}/',
        'model'         => '/models/',
        'helper'        => '/helpers/',
    );
    protected $default = 'library';

}