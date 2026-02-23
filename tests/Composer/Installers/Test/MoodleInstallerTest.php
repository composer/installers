<?php

namespace Composer\Installers\Test;

use Composer\Composer;
use Composer\Installers\MoodleInstaller;
use Composer\Repository\ArrayRepository;
use Composer\Repository\RepositoryManager;
use Composer\Util\HttpDownloader;

class MoodleInstallerTest extends TestCase
{
    /**
     * @dataProvider inflectionProvider
     * @param array<string, mixed> $rootExtras
     * @param array<string, mixed> $moodleExtras
     */
    public function testInflectPackageVars(
        string $expectedPublic,
        string $expectedRootPath,
        string $expectedName,
        string $expectedInstallPath,
        string $composerType,
        array $rootExtras,
        array $moodleExtras,
        string $packageName,
    ): void {
        $composer = $this->getComposer();
        $composer->getPackage()->setExtra($rootExtras);

        // Add the Moodle package to the repository manager.
        $repository = new ArrayRepository();
        $moodlePackage = $this->getPackage('moodle/moodle', '1.0.0');
        $moodlePackage->setExtra($moodleExtras);
        $repository->addPackage($moodlePackage);
        $composer->getRepositoryManager()->addRepository($repository);

        // Create the installer.
        $testPackage = $this->getPackage($packageName, '1.0.0');
        $testPackage->setType($composerType);
        $installer = new MoodleInstaller(
            $testPackage,
            $composer,
            $this->getMockIO()
        );

        $name = $testPackage->getPrettyName();
        $vendor = 'moodle';
        $type = $composerType;
        $result = $installer->inflectPackageVars(compact('name', 'vendor', 'type'));

        $this->assertEquals($result['public'], $expectedPublic);
        $this->assertEquals($result['prefix'], $expectedRootPath);
        $this->assertEquals($result['name'], $expectedName);
        $this->assertEquals($expectedInstallPath, $installer->getInstallPath($testPackage, 'moodle'));
    }

    public static function inflectionProvider(): array
    {
        return array(
            // Legacy install without public dir.
            array(
                '', // expected public path
                '', // expected install path
                'custommod', // expected name
                'mod/custommod/', // expected install path
                'moodle-mod', // composer type
                [], // root extras
                [],  // package extras
                'moodle-mod_custommod', // package name
            ),

            // Modern install moodle/moodle.
            array(
                '', // expected public path
                'moodle/', // expected install path
                'moodle', // expected name
                'moodle/', // expected install path
                'moodle-core', // composer type
                ['install-path' => 'moodle/'], // root extras
                [],  // package extras
                'moodle', // package name
            ),
            // Modern install with public dir and install path.
            array(
                'public/', // expected public path
                'moodle/', // expected install path
                'customblock', // expected name
                'moodle/public/blocks/customblock/', // expected install path
                'moodle-block', // composer type
                ['install-path' => 'moodle/'], // root extras
                ['haspublicdir' => true],  // package extras
                'moodle-block_customblock', // package name
            ),

            // Modern install with public dir and no install path.
            array(
                'public/', // expected public path
                '', // expected install path
                'customblock', // expected name
                'public/blocks/customblock/', // expected install path
                'moodle-block', // composer type
                [], // root extras
                ['haspublicdir' => true],  // package extras
                'moodle-block_customblock', // package name
            ),
        );
    }

    /**
     * {@inheritDoc}
     */
    protected function getComposer(): Composer
    {
        $composer = parent::getComposer();

        $repositoryManager = new RepositoryManager(
            $this->getMockIO(),
            $composer->getConfig(),
            $this->getMockBuilder(HttpDownloader::class)->disableOriginalConstructor()->getMock()
        );
        $composer->setRepositoryManager($repositoryManager);

        return $composer;
    }
}
