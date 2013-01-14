# A Multi-Framework [Composer](http://getcomposer.org) Library Installer

[![Build Status](https://secure.travis-ci.org/composer/installers.png)](http://travis-ci.org/composer/installers)

This is for PHP package authors to require in their `composer.json`. It will
install their package to the correct location based on the specified package
type.

The goal of `installers` is to be a simple package type to install path map.
Users can also customize the install path per package and package authors can
modify the package name upon installing.

`installers` isn't intended on replacing all custom installers. If your
package requires special installation handling then by all means, create a
custom installer to handle it.

**Current Supported Package Types**:

* AGL           `agl-`
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
* MediaWiki     `mediawiki-`
* phpBB         `phpbb-`
* PPI           `ppi-`
* SilverStripe  `silverstripe-`
* Symfony1      `symfony1-`
* TYPO3 Flow    `typo3-flow-`
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

This would install your package to the `Plugin/Ftp/` folder of a CakePHP app
when a user runs `php composer.phar install`.

So submit your packages to [packagist.org](http://packagist.org)!

## Current Supported Types

* AGL
    * agl-module
* CakePHP
    * **cakephp-plugin**
* CodeIgniter
    * codeigniter-library
    * codeigniter-third-party
    * codeigniter-module
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
* MediaWiki
    * mediawiki-extension
* phpBB
    * phpbb-extension
    * phpbb-style
    * phpbb-language
* PPI
    * **ppi-module**
* SilverStripe
    * silverstripe-module
    * silverstripe-theme
* symfony1
    * **symfony1-plugin**
* TYPO3 Flow
    * typo3-flow-package
    * typo3-flow-framework
    * typo3-flow-plugin
    * typo3-flow-site
    * typo3-flow-build
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

## Custom Install Names

If you're a package author and need your package to be named differently when
installed consider using the `installer-name` extra.

For example you have a package named `shama/cakephp-ftp` with the type
`cakephp-plugin`. Installing with `composer/installers` would install to the
path `Plugin/CakephpFtp`. Due to the strict naming conventions, you as a
package author actually need the package to be named and installed to
`Plugin/Ftp`. Using the following config within your **package** `composer.json`
will allow this:

``` json
{
    "name": "shama/cakephp-ftp",
    "type": "cakephp-plugin",
    "extra": {
        "installer-name": "Ftp"
    }
}
```

Please note the name entered into `installer-name` will be the final and will
not be inflected.

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

### Should we allow dynamic package types or paths? No.
What are they? The ability for a package author to determine where a package
will be installed either through setting the path directly in their
`composer.json` or through a dynamic package type: `"type":
"framework-install-here"`.

It has been proposed many times. Even implemented once early on and then
removed. `installers` won't do this because it would allow a single package
author to wipe out entire folders without the user's consent. That user would
then come here to yell at us.

