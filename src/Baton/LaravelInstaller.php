<?php
namespace Baton;

class LaravelInstaller extends BaseInstaller
{

    protected $locations = array(
        'app'           => '',
        'library'       => 'libraries/{name}/',
    );

}
