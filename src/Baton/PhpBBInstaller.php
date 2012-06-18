<?php
namespace Baton;

class PhpBBInstaller extends BaseInstaller
{

    protected $locations = array(
        'extension' => 'ext/{vendor}/{name}/',
    );
    protected $default = 'extension';

}