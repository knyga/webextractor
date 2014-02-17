<?php

namespace WebExtractor\DataExtractor\Concrete;

use WebExtractor\DataExtractor\AbstractDataExtractor;
use WebExtractor\DataExtractor\DataExtractorTypes;

/**
 * The TextDataExtractor class extracts data based on text.
 *
 * @author Sobit Akhmedov <sobit.akhmedov@gmail.com>
 * @author Oleksandr Knyga <oleksandrknyga@gmail.com>
 *
 * @package WebExtractor\DataExtractor
 */
class TextDataExtractor extends AbstractDataExtractor
{
    /**
     * Gets data extractor type.
     *
     * @return string Data extractor type
     */
    public function getType()
    {
        return DataExtractorTypes::TEXT;
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
        $this->getCrawler()->addContent($this->getContent());

        $elements = $this->getCrawler()->filter(":contains({$selector})");

        if (0 === $elements->count()) {
            return null;
        }

        return $selector;
    }
}
