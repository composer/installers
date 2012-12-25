<?php
namespace Composer\Installers;

class WordPressInstaller extends BaseInstaller {
    
    protected $default_locations = array(
        'plugin'    => '{$wp-plugins}/{$name}/',
        'theme'     => '${wp-themes}/{$name}/',
    );
    
    protected $locations = array();
    
    /**
     * {@inheritDoc}
     */
    public function getInstallPath(PackageInterface $package, $frameworkType = '') {
        $extra = $package->getExtra();
        
        $wp_content = !empty($extra['wpcontent_path']) ? $extra['wpcontent_path'] : 'wp-content';
        
        // check for a custom plugin or theme path
        $plugin_path = !empty($extra['wpplugin_path']) ? $extra['wpplugin_path'] : $wp_content . '/plugins';
        $themes_path = !empty($extra['wptheme_path']) ? $extra['wptheme_path'] : $wp_content . '/themes';
        
        $this->locations['plugin'] = str_replace('{$wp-plugins}', $plugin_path, $this->default_locations['plugin']);
        $this->locations['theme'] = str_replace('{$wp-themes}', $themes_path, $this->default_locations['theme']);
        
        return parent::getInstallPath($package, $frameworkType);
    }
}
