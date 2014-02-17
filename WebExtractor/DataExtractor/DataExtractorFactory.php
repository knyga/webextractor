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

use WebExtractor\DataExtractor\Concrete\CssDataExtractor;
use WebExtractor\DataExtractor\Concrete\RegexDataExtractor;
use WebExtractor\DataExtractor\Concrete\TextDataExtractor;
use WebExtractor\DataExtractor\Concrete\XPathDataExtractor;

use WebExtractor\Exception\InvalidDataExtractorTypeException;

/**
 * The DataExtractorFactory instantiates DataExtractor objects
 *
 * @author Oleksandr Knyga <oleksandrknyga@gmail.com>
 */
class DataExtractorFactory {
	private static $factory;

	private function __construct() {}

	public static function getFactory() {

		if(!static::$factory) {
			static::$factory = new DataExtractorFactory();
		}

		return static::$factory;
	}

	/**
	 * Instantiates DataExtractor objects
	 * 
	 * @param  string $type    DataExtractor type
	 * @return DataExtracotrInterface
	 * @throws InvalidDataExtractorTypeException
	 */
	public function createDataExtractor($type) {
		$extractor = null;

		switch($type) {
			case DataExtractorTypes::XPATH:
				$extractor = new XPathDataExtractor;
			break;

			case DataExtractorTypes::TEXT:
				$extractor = new TextDataExtractor;
			break;

			case DataExtractorTypes::REGEX:
				$extractor = new RegexDataExtractor;
			break;

			case DataExtractorTypes::CSS:
				$extractor = new CssDataExtractor;
			break;

			default:
				throw new RuntimeException;
		}

		return $extractor;
	}

	/**
	 * Instantiates DataExtractor objects
	 * 
	 * @param  string $input    {{type|selector}} or type|selector
	 * @return DataExtracotrInterface
	 * @throws InvalidDataExtractorTypeException
	 */
	public function createDataExtractorFromString($input) {
		$pattern = '/({{([^\|]+)\|(.+)}}|([^\|]+)\|(.+))/i';
		$type = null; $selector = null;

		if(preg_match($pattern, $input, $matches)) {

			if(!empty($matches[2]) && !empty($matches[3])) {
				$type = $matches[2];
				$selector = $matches[3];
			} elseif(!empty($matches[4]) && !empty($matches[5])) {
				$type = $matches[4];
				$selector = $matches[5];
			}
		} else {
			throw new InvalidDataExtractorTypeException;
		}

		$extractor = $this->createDataExtractor($type)
			->setSelector($selector);

		return $extractor;
	}
}