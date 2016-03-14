<?php
namespace Composer\Installers;

class DreamFactoryInstaller extends BaseInstaller
{
    /**
     * @type array This installer's paths
     */
    protected $locations = array(
        'plugin'  => 'storage/plugins/{$vendor}/{$name}/',
        'library' => 'storage/plugins/{$vendor}/{$name}/',
        //  DSP v1.x
        'app'     => 'web/{$name}/',
    );

    /**
     * DSP v1 uses "web" for HTML. DSP v2 will use "public". This
     * method checks to see which version we have and install to
     * the proper directory.
     *
     * @return array
     */
    public function getLocations()
    {
        static $_cwd = null;
        static $_paths = array(
            'public',
            'web',
        );

        if ( $_cwd === null )
        {
            $_cwd = getcwd();

            foreach ( $_paths as $_path )
            {
                if ( is_dir( $_cwd . '/' . $_path ) )
                {
                    $this->locations['app'] = $_path . '/{$name}/';
                    break;
                }
            }
        }

        return parent::getLocations();
    }

}
