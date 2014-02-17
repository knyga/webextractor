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

namespace WebExtractor\DataExtractor;

use WebExtractor\Exception\ContentNotSetException;
use WebExtractor\Exception\InvalidContentException;
use WebExtractor\Exception\SelectorNotSetException;
use WebExtractor\Exception\InvalidSelectorException;
//https://github.com/symfony/DomCrawler
use Symfony\Component\DomCrawler\Crawler;

/**
 * The AbstractDataExtractor is the base class for data extractors which implements common logic.
 *
 * @author Sobit Akhmedov <sobit.akhmedov@gmail.com>
 * @author Oleksandr Knyga <oleksandrknyga@gmail.com>
 *
 * @package WebExtractor\DataExtractor
 */
abstract class AbstractDataExtractor implements DataExtractorInterface
{
    /**
     * @var string
     */
    protected $content;

    /**
     * @var string
     */
    protected $selector;

    /**
     * @var Crawler
     */
    protected $crawler;

    /**
     * Sets content the data will be extracted from.
     *
     * @param string $content Content
     *
     * @throws InvalidContentException If content is not of type string
     * @return DataExtractorInterface
     */
    public function setContent($content)
    {
        if (!is_string($content)) {
            throw new InvalidContentException();
        }

        $this->content = $content;

        return $this;
    }

    /**
     * Gets content.
     *
     * If content was not set previously, will throw an exception.
     *
     * @throws ContentNotSetException If content is not set
     * @return string                 Content
     */
    public function getContent()
    {
        if (null === $this->content) {
            throw new ContentNotSetException();
        }

        return $this->content;
    }

     /**
     * Sets selector of the data will be extracted from.
     *
     * @param string $selector Selector
     *
     * @throws InvalidSelectorException If selector is not of type string
     * @return DataExtractorInterface
     */
    public function setSelector($selector)
    {
        if (!is_string($selector)) {
            throw new InvalidSelectorException();
        }

        $this->selector = $selector;

        return $this;
    }

    /**
     * Gets selector.
     *
     * If selector was not set previously, will throw an exception.
     *
     * @throws SelectorNotSetException If selector is not set
     * @return string                 Selector
     */
    public function getSelector()
    {
        if (null === $this->selector) {
            throw new SelectorNotSetException();
        }

        return $this->selector;
    }

    /**
     * Sets DOM crawler.
     *
     * @param Crawler $crawler DOM crawler
     *
     * @return XPathDataExtractor
     */
    public function setCrawler(Crawler $crawler)
    {
        $this->crawler = $crawler;

        return $this;
    }

    /**
     * Gets DOM crawler.
     *
     * If crawler is not set, new instance will be created.
     *
     * @return Crawler DOM crawler
     */
    public function getCrawler()
    {
        if (null === $this->crawler) {
            $this->crawler = new Crawler();
        }

        return $this->crawler;
    }
}
