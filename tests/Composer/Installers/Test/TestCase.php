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

namespace Composer\Installers\Test;

use Composer\Package\Version\VersionParser;
use Composer\Package\Package;
use Composer\Package\AliasPackage;
use Composer\Semver\Constraint\Constraint;
use Composer\Util\Filesystem;

abstract class TestCase extends PolyfillTestCase
{
    private static $parser;

    protected static function getVersionParser()
    {
        if (!self::$parser) {
            self::$parser = new VersionParser();
        }

        return self::$parser;
    }

    protected function getVersionConstraint($operator, $version)
    {
        return new Constraint(
            $operator,
            self::getVersionParser()->normalize($version)
        );
    }

    protected function getPackage($name, $version)
    {
        $normVersion = self::getVersionParser()->normalize($version);

        return new Package($name, $normVersion, $version);
    }

    protected function getAliasPackage($package, $version)
    {
        $normVersion = self::getVersionParser()->normalize($version);

        return new AliasPackage($package, $normVersion, $version);
    }

    protected function ensureDirectoryExistsAndClear($directory)
    {
        $fs = new Filesystem();
        if (is_dir($directory)) {
            $fs->removeDirectory($directory);
        }
        mkdir($directory, 0777, true);
    }

    /**
     * @param string      $exception
     * @param string|null $message
     * @param int|null    $code
     * @return void
     */
    public function setExpectedException($exception, $message = null, $code = null)
    {
        if (!class_exists('PHPUnit\Framework\Error\Notice')) {
            $exception = str_replace('PHPUnit\\Framework\\Error\\', 'PHPUnit_Framework_Error_', $exception);
        }
        if (method_exists($this, 'expectException')) {
            $this->expectException($exception);
            if (null !== $message) {
                $this->expectExceptionMessage($message);
            }
        } else {
            /** @phpstan-ignore-next-line */
            parent::setExpectedException($exception, $message, $code);
        }
    }
}
