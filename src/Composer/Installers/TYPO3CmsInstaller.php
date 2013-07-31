<?php
namespace Composer\Installers;

/**
 * Extension installer for TYPO3 CMS
 *
 * @author Sascha Egerer <sascha.egerer@dkd.de>
 */
class TYPO3CmsInstaller extends BaseInstaller 
{
    protected $locations = array(
        'extension'   => 'typo3conf/ext/{$name}/',
        'core'   => 'typo3_src/'
    );

    /**
     * {@inheritDoc}
     */
    public function supports($packageType) {
        return 'extension' === $packageType;
    }
}