<?php

namespace WebExtractor\DataExtractor;

use WebExtractor\Exception\ContentNotSetException;
use WebExtractor\Exception\InvalidContentException;

/**
 * The DataExtractorInterface interface is used to implement data extractors.
 *
 * @author Sobit Akhmedov <sobit.akhmedov@gmail.com>
 *
 * @package WebExtractor\DataExtractor
 */
interface DataExtractorInterface
{
    /**
     * Gets data extractor type.
     *
     * @return string Data extractor type
     */
    public function getType();

    /**
     * Extracts data based on the provided selector.
     *
     * @return string|null Extracted data if found, null otherwise
     */
    public function extract();

    /**
     * Sets content the data will be extracted from.
     *
     * @param string $content Content
     *
     * @throws InvalidContentException If content is not of type string
     * @return DataExtractorInterface
     */
    public function setContent($content);

    /**
     * Gets content.
     *
     * If content was not set previously, will throw an exception.
     *
     * @throws ContentNotSetException If content is not set
     * @return string                 Content
     */
    public function getContent();

     /**
     * Sets selector of the data will be extracted from.
     *
     * @param string $selector Selector
     *
     * @throws InvalidSelectorException If selector is not of type string
     * @return DataExtractorInterface
     */
    public function setSelector($selector);

    /**
     * Gets selector.
     *
     * If selector was not set previously, will throw an exception.
     *
     * @throws SelectorNotSetException If selector is not set
     * @return string                 Selector
     */
    public function getSelector();
}
