<?php

/*
 * This file is part of the WebExtractor package.
 *
 * 
 * (c) Sobit Akhmedov <sobit.akhmedov@gmail.com>, Oleksandr Knyga <oleksandrknyga@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WebExtractor\Test\DataExtractor;

use WebExtractor\DataExtractor\DataExtractorFactory;

use WebExtractor\DataExtractor\Concrete\CssDataExtractor;
use WebExtractor\DataExtractor\Concrete\RegexDataExtractor;
use WebExtractor\DataExtractor\Concrete\TextDataExtractor;
use WebExtractor\DataExtractor\Concrete\XPathDataExtractor;

/**
 * Class DataExtractorFactoryTest
 *
 * @package WebExtractor\Test\DataExtractor
 */
class DataExtractorFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DataExtractorFactory
     */
    private $factory;

    protected function setUp()
    {
        $this->factory = DataExtractorFactory::getFactory();
    }

    public function testCreateDataExtractorFromString() {
        $this->assertInstanceOf('\WebExtractor\DataExtractor\Concrete\CssDataExtractor', $this->factory->createDataExtractorFromString('css|.class'));
        $this->assertInstanceOf('\WebExtractor\DataExtractor\Concrete\RegexDataExtractor', $this->factory->createDataExtractorFromString('{{regex|/price: \d+/}}'));
    }

}
