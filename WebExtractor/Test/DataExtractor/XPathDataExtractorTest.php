<?php

namespace WebExtractor\Test\DataExtractor;

use WebExtractor\DataExtractor\DataExtractorTypes;
use WebExtractor\DataExtractor\Concrete\XPathDataExtractor;

/**
 * Class XPathDataExtractorTest
 *
 * @package WebExtractor\Test\DataExtractor
 */
class XPathDataExtractorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var XPathDataExtractor
     */
    private $extractor;

    protected function setUp()
    {
        $this->extractor = new XPathDataExtractor();
    }

    public function testInterface()
    {
        $this->assertInstanceOf('\WebExtractor\DataExtractor\DataExtractorInterface', $this->extractor);
    }

    public function testGetType()
    {
        $this->assertEquals(DataExtractorTypes::XPATH, $this->extractor->getType());
    }

    public function testExtractReturnsNullOnIncorrectContent()
    {
        $data = $this->extractor->setContent('incorrect content')->setSelector('test')->extract();
        $this->assertNull($data);
    }

    public function testExtract()
    {
        $html = '<html><body><h1>This is test HTML</h1></body></html>';
        $this->assertEquals('This is test HTML', $this->extractor->setContent($html)->setSelector('//body/h1')->extract());
    }

    public function testExtractReturnsFirstElement()
    {
        $html = '<html><body><h1>First</h1><h1>Second</h1></body></html>';
        $this->assertEquals('First', $this->extractor->setContent($html)->setSelector('//body/h1')->extract());
    }

    /**
     * @expectedException \WebExtractor\Exception\ContentNotSetException
     */
    public function testExtractThrowsExceptionWithoutContent()
    {
        $this->extractor->setSelector('test selector')->extract();
    }

    /**
     * @expectedException \WebExtractor\Exception\SelectorNotSetException
     */
    public function testExtractThrowsExceptionWithoutSelector()
    {
        $html = '<html><body><h1>First</h1><h1>Second</h1></body></html>';
        $this->extractor->setContent($html)->extract();
    }
}
