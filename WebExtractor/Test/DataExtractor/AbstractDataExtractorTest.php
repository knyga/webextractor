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

use WebExtractor\DataExtractor\AbstractDataExtractor;

/**
 * Class AbstractDataExtractorTest
 *
 * @package WebExtractor\Test\DataExtractor
 */
class AbstractDataExtractorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|AbstractDataExtractor
     */
    private $extractor;

    protected function setUp()
    {
        $this->extractor = $this->getMockForAbstractClass('\WebExtractor\DataExtractor\AbstractDataExtractor');
    }

    /**
     * @expectedException \WebExtractor\Exception\ContentNotSetException
     */
    public function testDefaultGetContentThrowsException()
    {
        $this->extractor->getContent();
    }

    /**
     * @expectedException \WebExtractor\Exception\InvalidContentException
     */
    public function testSetContentIntegerThrowsException()
    {
        $this->extractor->setContent(1);
    }

    /**
     * @expectedException \WebExtractor\Exception\InvalidContentException
     */
    public function testSetContentObjectThrowsException()
    {
        $this->extractor->setContent(new \stdClass());
    }

    /**
     * @expectedException \WebExtractor\Exception\InvalidContentException
     */
    public function testSetContentArrayThrowsException()
    {
        $this->extractor->setContent(['foo' => 'bar']);
    }

    /**
     * @expectedException \WebExtractor\Exception\InvalidContentException
     */
    public function testSetContentBooleanThrowsException()
    {
        $this->extractor->setContent(true);
    }

    /**
     * @expectedException \WebExtractor\Exception\InvalidContentException
     */
    public function testSetContentFloatThrowsException()
    {
        $this->extractor->setContent(1.23);
    }

    /**
     * @expectedException \WebExtractor\Exception\InvalidContentException
     */
    public function testSetContentNullThrowsException()
    {
        $this->extractor->setContent(null);
    }

    /**
     * @expectedException \WebExtractor\Exception\InvalidContentException
     */
    public function testSetContentCallbackThrowsException()
    {
        $this->extractor->setContent(function() { echo 'test'; });
    }

    /**
     * @expectedException \WebExtractor\Exception\SelectorNotSetException
     */
    public function testDefaultGetSelectorThrowsException()
    {
        $this->extractor->getSelector();
    }

    /**
     * @expectedException \WebExtractor\Exception\InvalidSelectorException
     */
    public function testSetSelectorIntegerThrowsException()
    {
        $this->extractor->setSelector(1);
    }

    /**
     * @expectedException \WebExtractor\Exception\InvalidSelectorException
     */
    public function testSetSelectorObjectThrowsException()
    {
        $this->extractor->setSelector(new \stdClass());
    }

    /**
     * @expectedException \WebExtractor\Exception\InvalidSelectorException
     */
    public function testSetSelectorArrayThrowsException()
    {
        $this->extractor->setSelector(['foo' => 'bar']);
    }

    /**
     * @expectedException \WebExtractor\Exception\InvalidSelectorException
     */
    public function testSetSelectorBooleanThrowsException()
    {
        $this->extractor->setSelector(true);
    }

    /**
     * @expectedException \WebExtractor\Exception\InvalidSelectorException
     */
    public function testSetSelectorFloatThrowsException()
    {
        $this->extractor->setSelector(1.23);
    }

    /**
     * @expectedException \WebExtractor\Exception\InvalidSelectorException
     */
    public function testSetSelectorNullThrowsException()
    {
        $this->extractor->setSelector(null);
    }

    /**
     * @expectedException \WebExtractor\Exception\InvalidSelectorException
     */
    public function testSetSelectorCallbackThrowsException()
    {
        $this->extractor->setSelector(function() { echo 'test'; });
    }
}
