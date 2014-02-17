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

namespace WebExtractor\DataExtractor\Concrete;

use WebExtractor\DataExtractor\AbstractDataExtractor;
use WebExtractor\DataExtractor\DataExtractorTypes;

/**
 * The RegexDataExtractor class extracts data based on regex.
 *
 * @author Oleksandr Knyga <oleksandrknyga@gmail.com>
 *
 * @package WebExtractor\DataExtractor
 */
class RegexDataExtractor extends AbstractDataExtractor
{
    /**
     * Gets data extractor type.
     *
     * @return string Data extractor type
     */
    public function getType()
    {
        return DataExtractorTypes::REGEX;
    }

    /**
     * Extracts data based on the provided selector.
     *
     * @return string|null Extracted data if found, null otherwise
     */
    public function extract()
    {
        $selector = $this->getSelector();

        $this->getCrawler()->clear();
        $content = $this->getContent();

        preg_match($selector, $content, $elements);
        $count = count($elements);

        if (null === $elements || 0 == $count) {
            return null;
        }

        if(1 == $count) {
            return $elements[0];
        } else {
            return $elements[1];
        }
    }
}
