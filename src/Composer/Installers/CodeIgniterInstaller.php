<?php
namespace Composer\Installers;

use Composer\Semver\Constraint\Constraint;

class CodeIgniterInstaller extends BaseInstaller
{

    protected $locations = array(
      'library'     => 'application/libraries/{$name}/',
      'helper' => 'application/helpers/{$name}/',
      'model' => 'application/models/{$name}/',
      'third-party' => 'application/third_party/{$name}/',
      'module'      => 'application/modules/{$name}/',
    );

    public function inflectPackageVars($vars)
    {
      if ($this->matchesVersion('>=', '3.11')) {
        return $vars;
      }

      $nameParts = explode('/', $vars['name']);
      foreach ($nameParts as &$value) {
        $value = strtolower(preg_replace('/(?<=\\w)([A-Z])/', '_\\1', $value));
        $value = str_replace(array('-', '_'), ' ', $value);
        $value = str_replace(' ', '', ucwords($value));
      }
      $vars['name'] = implode('/', $nameParts);
      return $vars;
    }

    /**
     * Check if CI version matches against a version
     *
     * @param string $matcher
     * @param string $version
     * @return bool
     */
    protected function matchesVersion($matcher, $version)
    {
      $repositoryManager = $this->composer->getRepositoryManager();
      if (! $repositoryManager) {
        return false;
      }

      $repos = $repositoryManager->getLocalRepository();
      if (!$repos) {
        return false;
      }

      return $repos->findPackage('codeigniter/framework',
        new Constraint($matcher, $version)) !== null;
    }

    /**
     * Ap automator - enter rebel
     */
    public function getLocations()
    {
      if ($this->matchesVersion('>=', '3.11')) {
        foreach ($this->locations as $key => $value) {
          $this->locations[$key] =
            $this->composer->getConfig()->get('vendor-dir') . '/{$vendor}/{$name}/';
        }
      }
      return $this->locations;
    }
}
