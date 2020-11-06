<?php

/*
 * This file is part of Composer.
 *
 * (c) Nils Adermann <naderman@naderman.de>
 *     Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Composer\Installers;

use Composer\EventDispatcher\Event;
use Composer\Package\RootPackageInterface;

/**
 * The pre remove disabled installers event.
 *
 * @author Simon Gilli <composer@gilbertsoft.org>
 */
class PreRemoveDisabledInstallersEvent extends Event
{
    /**
     * @var RootPackageInterface
     */
    private $package;

    /**
     * Constructor.
     *
     * @param string               $name    The event name
     * @param RootPackageInterface $package The root package
     */
    public function __construct($name, RootPackageInterface $package)
    {
        parent::__construct($name);
        $this->package = $package;
    }

    /**
     * Returns the package
     *
     * @return RootPackageInterface
     */
    public function getPackage()
    {
        return $this->package;
    }
}
