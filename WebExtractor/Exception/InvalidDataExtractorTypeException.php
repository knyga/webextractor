<?php

namespace WebExtractor\Exception;

/**
 * Class InvalidDataExtractorTypeException
 *
 * @package WebExtractor\Exception
 */
class InvalidDataExtractorTypeException extends \InvalidArgumentException
{
    public function __construct($dataExtractorType)
    {
        return parent::__construct(sprintf('Expected data extractor of type "\WebExtractor\DataExtractor\DataExtractorInterface", %s given', $dataExtractor));
    }
}
