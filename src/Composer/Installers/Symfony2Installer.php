<?php
namespace Composer\Installers;

/**
 * Plugin installer for symfony 2.x
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */
class Symfony2Installer extends BaseInstaller
{
    protected $locations = array(
        'bundle' => 'src/{$vendor}/{$name}/',
    );

    /**
     * {@inheritdoc}
     */
    protected function mapCustomInstallPaths(array $paths, $name)
    {
        // allow for wildcard in name, e.g., "vendor/*-bundle"
        foreach ($paths as $path => $names) {
            $pattern = str_replace('*', '.*', '{^(' . implode('|', $names) . ')$}');

            if (preg_match($pattern, $name)) {
                return $path;
            }
        }

        return false;
    }
}
