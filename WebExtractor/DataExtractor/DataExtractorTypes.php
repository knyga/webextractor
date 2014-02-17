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

/**
 * The DataExtractorTypes class contains constants related to different data extractor types.
 *
 * @author Sobit Akhmedov <sobit.akhmedov@gmail.com>
 *
 * @package WebExtractor\Common
 */
final class DataExtractorTypes
{
    /**
     * XPath data extractor type.
     */
    const XPATH = 'xpath';
    /**
     * CSS daata extractor type.
     */
    const CSS = 'css';
    /**
     * Text data extractor type.
     */
    const TEXT = 'text';
    /**
     * Regular expression data extractor type.
     */
    const REGEX = 'regex';
}
