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
