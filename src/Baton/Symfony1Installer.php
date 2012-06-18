<?php
namespace Baton;

/**
 * Plugin installer for symfony 1.x
 *
 * @author Jérôme Tamarelle <jerome@tamarelle.net>
 */
class Symfony1Installer extends BaseInstaller
{

    protected $locations = array(
        'plugin'    => 'plugins/{name}/',
    );
    protected $default = 'plugin';

}