<?php

namespace WebExtractor\Test\DataExtractor\Decorator;

use WebExtractor\Common\DataExtractorTypes;

use WebExtractor\DataExtractor\Decorator\DataExtractorGrabberDecorator;

use WebExtractor\DataExtractor\Concrete\CssDataExtractor;

use WebExtractor\Client\Client;
use WebExtractor\Test\AbstractTestCase;

/**
 * Class DataExtractorGrabberDecoratorTest
 *
 * @package WebExtractor\Test\DataExtractor\Decorator
 */
class DataExtractorGrabberDecoratorTest extends AbstractTestCase
{
    /**
     * @var Client
     */
    private $client;

    protected function setUp()
    {
        $this->client = new Client($this->createConfigStub(), $this->createEventDispatcherStub());
    }

    public function testCssDecorator() {
        $extractor = new DataExtractorGrabberDecorator(new CssDataExtractor(),
            $this->client,
            'https://en.wikipedia.org/wiki/2014_Winter_Olympics');
        $extractor->setSelector('h1');

        $this->assertEquals('2014 Winter Olympics', $extractor->extract());
    }
}
