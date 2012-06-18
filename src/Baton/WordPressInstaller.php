<?php
namespace Baton;

use Composer\Package\BasePackage;

class WordPressInstaller extends BaseInstaller
{

    protected $locations = array(
        'plugin'    => '/wp-content/plugins/{name}/',
        'theme'     => '/wp-content/themes/{name}/',
    );
    protected $default = 'plugin';

}