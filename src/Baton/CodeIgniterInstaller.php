<?php
namespace Baton;

use Composer\Package\BasePackage;

class CodeIgniterInstaller extends BaseInstaller
{

    protected $locations = array(
        'app'           => '/',
        'library'       => '/libraries/',
        'controller'    => '/controllers/',
        'third-party'   => '/third-party/',
        'model'         => '/models/',
        'helper'        => '/helpers/',
    );
    protected $default = 'library';

}