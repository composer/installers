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
* WordPress    `wordpress-`
* symfony1     `symfony1-`

Symfony and ZendFramework don't need this as they already work naturally with
Composer.

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

## Current Supported Types (Default Types in Bold)

* CakePHP
    * cakephp-app
    * cakephp-plugin
    * cakephp-lib
    * **cakephp-vendor**
    * cakephp-model
    * cakephp-behavior
    * cakephp-controller
    * cakephp-component
    * cakephp-helper
    * cakephp-theme
* CodeIgniter
    * codeigniter-app
    * **codeigniter-library**
    * codeigniter-controller
    * codeigniter-third-party
    * codeigniter-model
    * codeigniter-helper
* Drupal
    * **drupal-module**
    * drupal-theme
* FuelPHP
    * fuelphp-app
    * **fuelphp-module**
* Joomla
    * joomla-component
    * joomla-module
    * joomla-template
    * **joomla-plugin**
    * joomla-library
* Laravel
    * laravel-app
    * **laravel-library**
* Lithium
    * lithium-app
    * **lithium-library**
    * lithium-controller
    * lithium-extension
    * lithium-model
* phpBB
    * **phpbb-extension**
* WordPress
    * **wordpress-plugin**
    * wordpress-theme
* symfony1
    * **symfony1-plugin**

## Contribute!

Please fork and send a pull request against the `master` branch. Thanks!
