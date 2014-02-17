<?php

namespace WebExtractor\Exception;

/**
 * Class InvalidDataExtractorException
 *
 * @package WebExtractor\Exception
 */
class InvalidDataExtractorException extends \InvalidArgumentException
{
    public function __construct($dataExtractor)
    {
        return parent::__construct(sprintf('Expected data extractor of type "\WebExtractor\DataExtractor\DataExtractorInterface", %s given', is_object($dataExtractor) ? get_class($dataExtractor) : gettype($dataExtractor)));
    }
}
