WebExtractor
========================
Extracting data from web page with different extractors like css, xpath, regex...


Example
-----------

Code:

```php
<?php

use WebExtractor\DataExtractor\DataExtractorFactory;
use WebExtractor\DataExtractor\DataExtractorTypes;
use WebExtractor\Client\Client;

$factory = DataExtractorFactory::getFactory();
$extractor = $factory->createDataExtractor(DataExtractorTypes::CSS);
$client = new Client;
$content = $client->get('https://en.wikipedia.org/wiki/2014_Winter_Olympics');
$extractor->setContent($content);
$h1 = $extractor->setSelector('h1')->extract();
```

For more look tests.

Installation via [Composer](http://getcomposer.org/)
------------

 * Install Composer to your project root:
    ```bash
    curl -sS https://getcomposer.org/installer | php
    ```

 * Add a `composer.json` file to your project:
    ```json
    {
      "require" {
        "knyga/webextractor": "1.0.*@dev"
      }
    }
    ```

 * Run the Composer installer:
    ```bash
    php composer.phar install
    ```

License
-------

WebExtractor is licensed under the MIT license.

Sobit Akhmedov <sobit.akhmedov@gmail.com>

Oleksandr Knyga <oleksandrknyga@gmail.com>
