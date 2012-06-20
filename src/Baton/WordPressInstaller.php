<?php
namespace Baton;

class WordPressInstaller extends BaseInstaller
{

    protected $locations = array(
        'plugin'    => 'wp-content/plugins/{name}/',
        'theme'     => 'wp-content/themes/{name}/',
    );

}
