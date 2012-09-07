# A Multi-Framework [Composer](http://getcomposer.org) Library Installer

[![Build Status](https://secure.travis-ci.org/composer/installers.png)](http://travis-ci.org/composer/installers)

This is for PHP package authors to require in their `composer.json`. It will
magically install their package to the correct location based on the specified
package type.

**Current Supported Package Types**:

* CakePHP 2+    `cakephp-`
* CodeIgniter   `codeigniter-`
* Drupal        `drupal-`
* FuelPHP       `fuelphp-`
* Joomla        `joomla-`
* Kohana        `kohana-`
* Laravel       `laravel-`
* Lithium       `lithium-`
* Magento       `magento-`
* Mako          `mako-`
* phpBB         `phpbb-`
* PPI           `ppi-`
* SilverStripe  `silverstripe-`
* Symfony1      `symfony1-`
* WordPress     `wordpress-`
* Zend          `zend-`

**Natively Supported Frameworks**:

The following frameworks natively work with Composer and will be
installed to the default `vendor` directory. `composer/installers`
is not needed to install packages with these frameworks:

* Aura
* Symfony2

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
    * **cakephp-plugin**
* CodeIgniter
    * codeigniter-library
    * codeigniter-third-party
* Drupal
    * **drupal-module**
    * **drupal-theme**
    * drupal-profile
    * drupal-drush
* FuelPHP
    * fuelphp-module
* Joomla
    * joomla-component
    * joomla-module
    * joomla-template
    * joomla-plugin
    * joomla-library
* Kohana
    * **kohana-module**
* Laravel
    * laravel-library
* Lithium
    * **lithium-library**
    * **lithium-source**
* Magento
    * magento-library
    * magento-skin
    * magento-theme
* Mako
    * mako-package 
* phpBB
    * phpbb-extension
* PPI
    * **ppi-module**
* SilverStripe
    * silverstripe-module
    * silverstripe-theme
* symfony1
    * **symfony1-plugin**
* WordPress
    * **wordpress-plugin**
    * **wordpress-theme**
* Zend
    * zend-library
    * zend-extra

Types in **bold** have been marked stable and you can rely on those install
paths to not change. A new type must be created if any adjustments are
requested for an install path.

## Custom Install Paths

If you are consuming a package that uses the `composer/installers` you can
override the install path with the following extra in your `composer.json`:

``` json
{
    "extra": {
        "installer-paths": {
            "your/custom/path/{$name}/": ["shama/ftp", "vendor/package"]
        }
    }
}
```

This would use your custom path for each of the listed packages. The available
variables to use in your paths are: `${name}`, `{$vendor}`, `{$type}`.

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

