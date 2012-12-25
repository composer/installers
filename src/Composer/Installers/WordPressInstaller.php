<?php
namespace Composer\Installers;

class WordPressInstaller extends BaseInstaller {
    
    protected $locations = array(
        'plugin'    => '{$wpplugins}/{$name}/',
        'theme'     => '{$wpthemes}/{$name}/',
    );
    
    /**
     * Inject wp-content, plugin, and theme extras into path
     */
    public function inflectPackageVars($vars) {
        $extra = $this->package->getExtra();
        
        $wp_content = !empty($extra['wpcontent-path']) ? $extra['wpcontent-path'] : 'wp-content';
        
        $vars['wpplugins'] = !empty($extra['wpplugins-path']) ? $extra['wpplugins-path'] : $wp_content . '/plugins';
        $vars['wpthemes'] = !empty($extra['wpthemes-path']) ? $extra['wpthemes-path'] : $wp_content . '/themes';
        
        return $vars;
    }
}
