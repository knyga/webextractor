<?php

namespace WebExtractor\Test\DataExtractor;

use WebExtractor\DataExtractor\DataExtractorTypes;
use WebExtractor\DataExtractor\Concrete\CssDataExtractor;

/**
 * Class CssDataExtractorTest
 *
 * @package WebExtractor\Test\DataExtractor
 */
class CssDataExtractorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CssDataExtractor
     */
    private $extractor;

    protected function setUp()
    {
        $this->extractor = new CssDataExtractor();
    }

    public function testInterface()
    {
        $this->assertInstanceOf('\WebExtractor\DataExtractor\DataExtractorInterface', $this->extractor);
    }

    public function testGetType()
    {
        $this->assertEquals(DataExtractorTypes::CSS, $this->extractor->getType());
    }

    public function testExtractReturnsNullOnIncorrectContent()
    {
        $data = $this->extractor->setContent('incorrect content')->setSelector('test')->extract();
        $this->assertNull($data);
    }

    public function testExtract()
    {
        $html = '<html><body><h1>This is test HTML</h1></body></html>';
        $this->assertEquals('This is test HTML', $this->extractor->setContent($html)->setSelector('body h1')->extract());
        $this->assertEquals('This is test HTML', $this->extractor->setContent($html)->setSelector('h1')->extract());
    }

    public function testExtractReturnsFirstElement()
    {
        $html = '<html><body><h1>First</h1><h1>Second</h1></body></html>';
        $this->assertEquals('First', $this->extractor->setContent($html)->setSelector('body h1')->extract());
    }

    public function testExtractFromXpath()
    {
        $html = '<html><body><h1 id="f">First</h1><h1>Second</h1></body></html>';
        $this->assertEquals('First', $this->extractor->setContent($html)->setSelector('*[id=f]')->extract());

        $html = '<html><body><h1 id="f">First<span>me</span></h1><h1>Second</h1></body></html>';
        $this->assertEquals('me', $this->extractor->setContent($html)->setSelector('*[id=f] > span')->extract());
    }

    public function testExtractEqWrapperTest() {
        $html = "<html><body>
        <h1 id=\"f\">
            <span>one</span>
            <span>two</span>
            <span>
                <span>three one</span>
                <span>three two</span>
            </span>
        </h1>
        <h1>Second</h1>
        </body></html>";

        $this->assertEquals('two', $this->extractor->setContent($html)->setSelector('#f > span:eq(1)')->extract());
        $this->assertEquals('three two', $this->extractor->setContent($html)->setSelector('#f > span:eq(2) > span:eq(1)')->extract());
        $this->assertEquals('three two', $this->extractor->setContent($html)->setSelector('#f > span:eq(2) > span:contains("two")')->extract());
    }

    /**
     * @expectedException \WebExtractor\Exception\ContentNotSetException
     */
    public function testExtractThrowsExceptionWithoutContent()
    {
        $this->extractor->setSelector('test selector')->extract();
    }

    public function testValidate() {
           
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
