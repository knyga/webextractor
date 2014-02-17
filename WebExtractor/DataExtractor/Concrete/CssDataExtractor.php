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
 * The CssDataExtractor class extracts data based on CSS selectors.
 *
 * @author Oleksandr Knyga <oleksandrknyga@gmail.com>
 * @author Sobit Akhmedov <sobit.akhmedov@gmail.com>
 *
 * @package WebExtractor\DataExtractor
 */
class CssDataExtractor extends AbstractDataExtractor
{
    /**
     * Gets data extractor type.
     *
     * @return string Data extractor type
     */
    public function getType()
    {
        return DataExtractorTypes::CSS;
    }

    /**
     * Extracts data based on the provided selector.
     *
     * @return string|null Extracted data if found, null otherwise
     */
    public function extract()
    {
        $nodes = $this->getNodes();

        if(null === $nodes) {
            return null;
        }

        return $nodes->first()->text();
    }

    /**
     * Extracts attribute content based on the provided selector.
     *
     * @return string|null Extracted data if found, null otherwise
     */
    public function extractAttribute($attrName) {
        $nodes = $this->getNodes();

        if(null === $nodes) {
            return null;
        }

        return $nodes->first()->attr($attrName);
    }

    private function getNodes() {
        $selector = $this->getSelector();

        $this->getCrawler()->clear();
        $this->getCrawler()->addContent($this->getContent());

        $elements = $this->eqFilterWrapper($this->getCrawler(), $selector);

        if (0 === $elements->count()) {
            return null;
        }

        return $elements;
    }

    /**
     * Processor do not supports queries with :eq()
     * To correctly perform filering, selector should be wrapped with ->eq methods
     * @param  string $selector
     * @return Crawler
     */
    private function eqFilterWrapper($filtered, $selector) {
        $pattern = '/(\:eq\(\s*\d+\s*\)|(\>))/i';
        $eqPattern = '/\:eq\(\s*(\d+)\s*\)/i';
        $childrenPattern = '/\>/';

        $split_matches = preg_split($pattern, trim($selector));
        preg_match_all($pattern, $selector, $tag_matches);
        $tags = $tag_matches[1];

        $filtered = $filtered->filter($split_matches[0]);

        for($i=0, $l = count($tags); $i<$l; $i++) {

            if(preg_match($eqPattern, $tags[$i], $matches)) {
                $filtered = $filtered->eq($matches[1]);
            } elseif(preg_match($childrenPattern, $tags[$i])) {
                $filtered = $filtered->children();
            }

            $filterSelector = trim($split_matches[$i+1]);

            if(!empty($filterSelector)) {
                $filtered = $filtered->filter($filterSelector);
            }
        }

        return $filtered;
    }
}
