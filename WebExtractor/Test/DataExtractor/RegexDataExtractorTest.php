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

use WebExtractor\DataExtractor\DataExtractorTypes;
use WebExtractor\DataExtractor\Concrete\RegexDataExtractor;

/**
 * Class TextDataExtractorTest
 *
 * @package WebExtractor\Test\DataExtractor
 */
class RegexDataExtractorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TextDataExtractor
     */
    private $extractor;

    protected function setUp()
    {
        $this->extractor = new RegexDataExtractor();
    }

    public function testInterface()
    {
        $this->assertInstanceOf('\WebExtractor\DataExtractor\DataExtractorInterface', $this->extractor);
    }

    public function testGetType()
    {
        $this->assertEquals(DataExtractorTypes::REGEX, $this->extractor->getType());
    }

    public function testExtractReturnsNullOnIncorrectContent()
    {
        $data = $this->extractor->setContent('incorrect content')->setSelector('/this[^\<]+/i')->extract();
        $this->assertNull($data);
    }

    public function testExtract()
    {
        $html = '<html><body><h1>This is test HTML</h1></body></html>';
        $this->assertEquals('This is test HTML', $this->extractor->setContent($html)->setSelector('/this[^\<]+/i')->extract());
    }

    public function testGroupExtract()
    {
        $html = '<html><body><h1>This is test HTML</h1></body></html>';
        $this->assertEquals('This is test HTML', $this->extractor->setContent($html)->setSelector('/(this.+?)\<\//i')->extract());
    }

    /**
     * @expectedException \WebExtractor\Exception\ContentNotSetException
     */
    public function testExtractThrowsExceptionWithoutContent()
    {
        $this->extractor->setSelector('/this[^\<]+/i')->extract();
    }

    /**
     * @expectedException \WebExtractor\Exception\SelectorNotSetException
     */
    public function testExtractThrowsExceptionWithoutSelector()
    {
        $html = '<html><body><h1>First</h1><h1>Second</h1></body></html>';
        $this->extractor->setContent($html)->extract();
    }

    // /**
    //  * @expectedException \WebExtractor\Exception\InvalidSelectorException
    //  */
    // public function testExtractThrowsExceptionNoSlashSelector()
    // {
    //     $html = '<html><body><h1>First</h1><h1>Second</h1></body></html>';
    //     $this->extractor
    //         ->setContent($html)
    //         ->setSelector('no shashes')
    //         ->extract();
    // }
}
