Data Normalizer
===============
Normalize mobile, telephone, date, address, postcode. national number and ... . And validate them.  Star

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist aminkt/normalizer "*"
```

or add

```
"aminkt/normalizer": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \aminkt\normalizer\Normalize::normalizeMobile($mobile); ?>
```


Authors
-------
Normalizer:

[Amin Keshavarz](keshavarz.pro) <amin@kehsvarz.pro>

Validators: 

[Amin Keshavarz](http://keshavarz.pro) [amin@kehsvarz.pro](mailto:amin@kehsvarz.pro)

[Mojtaba Anisi](mailto:geevepahlavan@yahoo.com)

[Shahrokh Niakan](mailto:sh.niakan@anetwork.ir)
