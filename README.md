# Baton: A Multi-Framework [Composer](http://getcomposer.org) Library Installer

[![Build Status](https://secure.travis-ci.org/shama/baton.png)](http://travis-ci.org/shama/baton)

This is for PHP package authors to require in their `composer.json`. It will
magically install their package to the correct location based on the specified
package type.

**Current Supported Package Types**:

* CakePHP 2+   `cakephp-`
* CodeIgniter  `codeigniter-`
* Drupal       `drupal-`
* FuelPHP      `fuelphp-`
* Joomla       `joomla-`
* Laravel      `laravel-`
* Lithium      `lithium-`
* phpBB        `phpbb-`
* Symfony1     `symfony1-`
* WordPress    `wordpress-`
* Zend         `zend-`

## Example `composer.json` File

This is an example for a CakePHP plugin. The only important parts to set in your
composer.json file are `"type": "cakephp-plugin"` which tells Baton what your
package is and `"require": { "shama/baton": "*" }` which tells composer to use
the Baton installer.

``` json
{
	"name": "shama/ftp",
	"type": "cakephp-plugin",
	"require": {
		"php": ">=5.3",
		"shama/baton": "*"
	}
}
```

This would install your package to the `app/Plugin/Ftp/` folder of a CakePHP app
when a user runs `php composer.phar install`.

So submit your packages to [packagist.org](http://packagist.org)!

## Current Supported Types

* CakePHP
    * cakephp-app
    * cakephp-plugin
    * cakephp-lib
    * cakephp-vendor
    * cakephp-model
    * cakephp-behavior
    * cakephp-controller
    * cakephp-component
    * cakephp-helper
    * cakephp-theme
* CodeIgniter
    * codeigniter-app
    * codeigniter-library
    * codeigniter-controller
    * codeigniter-third-party
    * codeigniter-model
    * codeigniter-helper
* Drupal
    * drupal-module
    * drupal-theme
* FuelPHP
    * fuelphp-app
    * fuelphp-module
* Joomla
    * joomla-component
    * joomla-module
    * joomla-template
    * joomla-plugin
    * joomla-library
* Laravel
    * laravel-app
    * laravel-library
* Lithium
    * lithium-app
    * lithium-library
    * lithium-controller
    * lithium-extension
    * lithium-model
* phpBB
    * phpbb-extension
* Symfony1
    * symfony1-plugin
* WordPress
    * wordpress-plugin
    * wordpress-theme
* Zend
    * zend-library
    * zend-extra

## Roll Your Own Path

You can customize where your package will be installed by setting `baton.path`
in your `composer.json` extras:

``` json
{
	"name": "shama/ftp",
	"type": "cakephp-plugin",
	"require": {
		"php": ">=5.3",
		"shama/baton": "*"
	},
    "extras": {
        "baton": {
            "path": "Custom/Path/{vendor}/{name}/",
        }
    }
}
```

This would install this package to `Custom/Path/shama/ftp/`. The available
var `{options}` in Baton are: `vendor`, `name` and `type`.

## Contribute!

Please fork and send a pull request against the `master` branch. Thanks!

Baton uses [PHPUnit](http://phpunit.de). Please use `phpunit -c tests` to run
the test suite.
