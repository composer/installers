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

/**
 * The Installer Events.
 *
 * @author Simon Gilli <composer@gilbertsoft.org>
 */
class InstallerEvents
{
    /**
     * The PRE_REMOVE_DISABLED_INSTALLERS event occurs before the disabled
     * installers gets removed and lets you modify the root package if needed.
     *
     * The event listener method receives a
     * Composer\Installers\PreRemoveDisabledInstallersEvent instance.
     *
     * @var string
     */
    const PRE_REMOVE_DISABLED_INSTALLERS = 'pre-remove-disabled-installers';
}
