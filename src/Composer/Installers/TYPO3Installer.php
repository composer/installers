<?php
namespace Composer\Installers;

/**
 * An installer to handle TYPO3 Flow specifics when installing packages.
 */
class TYPO3Installer extends BaseInstaller
{

    /**
     * Modify the package name to be a TYPO3 Flow style key.
     *
     * @param array $vars
     * @return array
     */
    public function inflectPackageVars($vars)
    {

        if (strlen($vars['type']) <= 11 || substr($vars['type'], 0, 11) !== 'typo3-flow-')
        {
           throw new \UnexpectedValueException('Currrently only TYPO3 Flow packages are supported by the TYPO3 installer');
        }
        // infer package location from package type
        $packageLocation = strtolower(substr($vars['type'], 11));
        switch ($packageLocation)
        {
            case 'package':
                $this->locations['flow-package'] = 'Packages/Application/{$name}/';
                break;
            case 'plugin':
            case 'site':
                $this->locations['flow-' . $packageLocation] = 'Packages/' . ucfirst($packageLocation) . 's/{$name}/';
                break;
            case 'build':
                $this->locations['flow-build'] = 'Build/{$name}/';
                break;
            default:
                $this->locations['flow-' . $packageLocation] = 'Packages/' . ucfirst($packageLocation) . '/{$name}/';
                break;
        }

        $autoload = $this->package->getAutoload();
        if (isset($autoload['psr-0']) && is_array($autoload['psr-0']))
        {
            $namespace = key($autoload['psr-0']);
            $vars['name'] = str_replace('\\', '.', $namespace);
        } else {
            $extraSettings = $this->package->getExtra();
            if(isset($extraSettings['typo3/flow']['case-sensitive-package-name'])) {
                $vars['name'] = $extraSettings['typo3/flow']['case-sensitive-package-name'];
            }
        }
        return $vars;
    }
}

?>