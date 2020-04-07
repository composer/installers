# Change Log

## v1.9.0 - 2020-04-07
## Added
* Added support for Composer 2.0
* Added drupal-database-driver type to Drupal Framework, [#452](https://github.com/composer/installers/pull/452)
* Added support for declaring installer-paths values as strings [#449](https://github.com/composer/installers/pull/449)

## v1.8.0 - 2020-02-07
## Added
* Added support for MantisBT plugins, [#442](https://github.com/composer/installers/pull/442).
* Added drupal-config type to Drupal Framework, [#440](https://github.com/composer/installers/pull/440).
* Added support for Sylius themes, [#445](https://github.com/composer/installers/pull/445).

## v1.7.0 - 2019-08-12
## Added
* Added support for Redaxo v5, [#410](https://github.com/composer/installers/pull/410).
* Added TAO extensions installer, [#424](https://github.com/composer/installers/pull/424).
* Added Know installer, [#425](https://github.com/composer/installers/pull/425).
* Added support for Drupal Console custom packages and languages, [#311](https://github.com/composer/installers/pull/311).
* Added Drupal custom profile installation path, [#416](https://github.com/composer/installers/pull/416).
* Add support drupal-site type, [#417](https://github.com/composer/installers/pull/417).
* Added `customcertelement` for Moodle, [#408](https://github.com/composer/installers/pull/408).
* Added Dframe installer, [#404](https://github.com/composer/installers/pull/404).
* Added WHMCS installer, [#401](https://github.com/composer/installers/pull/401).

## Fixed
* Get `target-dir` from package attributes, [#432](https://github.com/composer/installers/pull/432).

## Deprecated
* Deprecated Pimcore installer, [#400](https://github.com/composer/installers/pull/400).

## v1.6.0 - 2018-09-12
## Added
* Added ability to disable all or certain installers, [#376](https://github.com/composer/installers/pull/376).
* Added MediaWiki Core, [#391](https://github.com/composer/installers/pull/391).
* Added CiviCrm installer, [#385](https://github.com/composer/installers/pull/385).

## Fixed
* Normalise vendor directory containing hyphen, [#397](https://github.com/composer/installers/pull/397).

## v1.5.0 - 2017-12-29
### Added
* Added WordPress dropin support.
* Added new types supported for Eliasis.
* Added support for Phoenix CMS.
* Added MODX installer.
* Added Majima instaler.
* Added SiteDirect installer.
* Added support optional prefix in OctoberCMS installers.
* Added PHP 7.2 support.

### Changed
* Changed remove packages, see [#348](https://github.com/composer/installers/pull/348).

### Fixed
* Fixed code style, removed unused imports.

## v1.4.0 - 2017-08-09
### Added
* Installer for eZ Platform.
* Installer for UserFrosting.
* Installer for Osclass.
* Installer for Lan Management System.

### Changed
* Added vendor name to package path for Lavalite.

## v1.3.0 - 2017-04-24
### Added
* Kanboard plugins installer.
* Porto-SAP installer.
* Add `core` to concrete5 installer.
* Support Moodle "search" plugin type.
* SyDES installer.
* iTop installer.
* Lavalite installer.
* Module type for Eliasis.
* Vgmcp installer.
* OntoWiki installer.
* The requirements for contributing (CONTRIBUTING.md).

## v1.2.0 - 2016-08-13
### Added
* Installer for Attogram.
* Installer for Cockpit.
* Installer for Plentymarkets.
* Installer for ReIndex.
* Installer for Vanilla.
* Installer for YAWIK.
* Added missing environments for new Shopware (5.2) Plugin System.

## v1.1.0 - 2016-07-05
### Added
* Installer for ReIndex.
* Installer for RadPHP.
* Installer for Decibel.
* Installer for Phifty.
* Installer for ExpressionEngine.

### Changed
* New paths for new Bitrix CMS. Old paths is deprecated.

### Deprecated
* Old paths in Bitrix CMS Installer is deprecated.

## v1.0.25 - 2016-04-13
### Removed
* Revert TYPO3 installer deletion.

## v1.0.24 - 2016-04-05
### Added
* Installer for ImageCMS.
* Installer for Mautic.
* New types in the Kirby installer: `kirby-plugin` and `kirby-field`.
* New types in the Drupal installer: `custom-theme` and `custom-module`.

### Changed
* Switch to PSR-4.
* Update Bitrix Installer: configuration for setting custom path to directory with kernel.

### Removed
* Remove TYPO3 Extension installers.
