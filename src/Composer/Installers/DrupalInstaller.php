<?php
namespace Composer\Installers;

/**
 * The Drupal Installer for Composer Installers.
 *
 * This locates Drupal's root directory, and installs into sites/all if
 * the path is available. Note that much of this was adopted from Drush.
 *
 * @link http://drupal.org/project/drush
 */
class DrupalInstaller extends BaseInstaller
{
    protected $locations = array(
        'module'    => '{$root}/modules/{$name}/',
        'theme'     => '{$root}/themes/{$name}/',
        'profile'   => '{$root}/profiles/{$name}/',
        'drush'     => '{$root}/drush/{$name}/',
    );

    /**
     * {@inheritDoc}
     */
    public function inflectPackageVars($vars)
    {
        // Find Drupal's root directory.
        $root = $this->locateDrupalRoot();
        if ($root) {
            // If we are installing on Drupal 5, 6 or 7, use "sites/all".
            if (version_compare($this->drupalMajorVersion($root), '8', '<')) {
                $root .= '/sites/all';
            }
        }
        else {
            // If it's not a valid directory, then use the current directory.
            $root = '.';
        }

        // Inject Drupal's root directory into the variables array.
        $vars['root'] = $root;

        return $vars;
    }

    /**
     * Checks whether given path qualifies as a Drupal root.
     *
     * @param $path
     *   The relative path to common.inc (varies by Drupal version), or FALSE if
     *   not a Drupal root.
     */
    protected function validDrupalRoot($path) {
        if (!empty($path) && is_dir($path)) {
          $candidates = array('includes/common.inc', 'core/includes/common.inc');
          foreach ($candidates as $candidate) {
            if (file_exists($path . '/' . $candidate)) {
              return $candidate;
            }
          }
        }

        return false;
    }

    /**
     * Exhaustive depth-first search to try and locate the Drupal root directory.
     */
    protected function locateDrupalRoot($path = '')
    {
        $path = empty($path) ? getcwd() : $path;
        do {
            if ($this->validDrupalRoot($path)) {
                return $path;
            }
        }
        while ($path = dirname($path) && $path != DIRECTORY_SEPARATOR);

        return false;
    }

    /**
    * Return the user's home directory.
    */
    protected function serverHome() {
        $home = getenv('HOME');

        if (empty($home)) {
            if (!empty($_SERVER['HOMEDRIVE']) && !empty($_SERVER['HOMEPATH'])) {
                // On a Windows server.
                $home = $_SERVER['HOMEDRIVE'] . $_SERVER['HOMEPATH'];
            }
        }

        return empty($home) ? NULL : $home;
    }

    /**
     * Retrieves Drupal version.
     *
     * @return string A version string similar to 7.22-dev.
     */
    protected function drupalVersion($drupal_root = null) {
        if (($drupal_root != null) || ($drupal_root = $this->locateDrupalRoot())) {
            // Drupal 7 stores VERSION in includes/bootstrap.inc, while Drupal 8
            // uses core/includes/bootstrap.inc.
            $version_constant_paths = array('/modules/system/system.module', '/includes/bootstrap.inc', '/core/includes/bootstrap.inc');
            foreach ($version_constant_paths as $path) {
                if (file_exists($drupal_root . $path)) {
                    require_once $drupal_root . $path;
                }
            }

            if (defined('VERSION')) {
               return VERSION;
            }
        }
    }

    /**
     * Retrieves Drupal's major version number.
     */
    protected function drupalMajorVersion($drupal_root = null)
    {
        $major_version = false;
        if ($version = $this->drupalVersion($drupal_root)) {
            $version_parts = explode('.', $version);
            if (is_numeric($version_parts[0])) {
                $major_version = (integer) $version_parts[0];
            }
        }

        return $major_version;
    }
}
