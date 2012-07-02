# A Multi-Framework [Composer](http://getcomposer.org) Library Installer

[![Build Status](https://secure.travis-ci.org/composer/installers.png)](http://travis-ci.org/composer/installers)

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
* Magento      `magento-`
* phpBB        `phpbb-`
* PPI          `ppi-`
* Symfony1     `symfony1-`
* WordPress    `wordpress-`
* Zend         `zend-`

## Example `composer.json` File

This is an example for a CakePHP plugin. The only important parts to set in your
composer.json file are `"type": "cakephp-plugin"` which describes what your
package is and `"require": { "composer/installers": "*" }` which tells composer
to load the custom installers.

``` json
{
    "name": "you/ftp",
    "type": "cakephp-plugin",
    "require": {
        "composer/installers": "*"
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
    * cakephp-datasource
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
    * lithium-source
* Magento
    * magento-library
    * magento-skin
    * magento-theme
* phpBB
    * phpbb-extension
* PPI
    * ppi-module
* symfony1
    * symfony1-plugin
* WordPress
    * wordpress-plugin
    * wordpress-theme
* Zend
    * zend-library
    * zend-extra

## Contribute!

* [Fork and clone](https://help.github.com/articles/fork-a-repo).
* Run the command `php composer.phar install --dev` to install the dev
  dependencies. See [Composer](https://github.com/composer/composer#installation--usage).
* Use the command `phpunit` to run the tests. See [PHPUnit](http://phpunit.de).
* Create a branch, commit, push and send us a
  [pull request](https://help.github.com/articles/using-pull-requests).

To ensure a consistent code base, you should make sure the code follows the
[Coding Standards](http://symfony.com/doc/2.0/contributing/code/standards.html)
which we borrowed from Symfony.

If you would like to help, please take a look at the list of
[issues](https://github.com/composer/installers/issues).

