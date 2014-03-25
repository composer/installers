<?php
namespace Composer\Installers;

class ExpressionEngine extends BaseInstaller
{
    protected $locations = array(
        'addon' => 'system/expressionengine/thirdparty/{$name}/',
    );
}
