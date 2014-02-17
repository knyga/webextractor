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

namespace WebExtractor\DataExtractor\Decorator;

use WebExtractor\Exception\ContentNotSetException;
use WebExtractor\Exception\InvalidContentException;

use WebExtractor\DataExtractor\AbstractDataExtractor;
use WebExtractor\DataExtractor\DataExtractorInterface;

use WebExtractor\Client\ClientInterface;

/**
 * Wraps DataExtractor with client to get content
 *
 * @author Oleksandr Knyga <oleksandrknyga@gmail.com>
 */
class DataExtractorGrabberDecorator extends AbstractDataExtractor {
	private $extractor;
	private $client;
	private $url;
	private $method;

	public function __construct(DataExtractorInterface $extractor, ClientInterface $client, $url, $method = 'GET') {
		$this->extractor = $extractor;
		$this->client = $client;
		$this->url = $url;
		$this->method = $method;
	}

    /**
     * Extracts data based on the provided selector.
     *
     * @return string|null Extracted data if found, null otherwise
     */
	public function extract() {
		$this->extractor->setContent($this->getContent());
		return $this->extractor->extract();
	}

	/**
	 * @return string
	 */
	public function getContent() {
		$content = null;

		try {
			$content = $this->extractor->getContent();
		} catch(ContentNotSetException $e) {
			$content = $this->requestContent($this->getMethod(), $this->getUrl());
		}

		return $content;
	}

	/**
     * @param string $content
	 * @return DataExtractorGrabberDecorator
	 */
	public function setContent($content) {
		$this->extractor->setContent($content);
		return $this;
	}

	/**
	 * @return string
	 */
	public function getSelector() {
		return $this->extractor->getSelector();
	}

	/**
     * @param string $selector
	 * @return DataExtractorGrabberDecorator
	 */
	public function setSelector($selector) {
		$this->extractor->setSelector($selector);
		return $this;
	}

    /**
     * Fetches content by sending HTTP request of the provided method to the provided URL with the provided params.
     *
     * Checks if HTTP request method is GET or POST, otherwise throws exception.
     *
     * @param string $method HTTP request method
     * @param string $url    URL
     * @param array  $params HTTP params
     *
     * @throws InvalidRequestMethodException If HTTP request method is neither GET nor POST
     * @return string                        Fetched content
     */
	private function requestContent($method, $url, array $params = []) {
        $method = strtolower($method);
        if (!in_array($method, ['get', 'post'])) {
            throw new InvalidRequestMethodException($method, ['get', 'post']);
        }

        if ('get' === $method) {
            $content = $this->getClient()->get($url, $params);
        } else {
            $content = $this->getClient()->post($url, $params);
        }

        return $content;
	}

    /**
     * Gets data extractor type.
     *
     * @return string Data extractor type
     */
    public function getType()
    {
        return $this->extractor->getType();
    }

	/**
	 * @return string
	 */
	public function getMethod() {
		return $this->method;
	}

	/**
     * @param string $method
	 * @return DataExtractorGrabberDecorator
	 */
	public function setMethod($method) {
		$this->method = $method;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getUrl() {
		return $this->url;
	}

	/**
     * @param string $url
	 * @return DataExtractorGrabberDecorator
	 */
	public function setUrl($url) {
		$this->url = $url;
		return $this;
	}

    /**
     * @return ClientInterface
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param ClientInterface $client
     *
     * @return DataExtractorGrabberDecorator
     */
    public function setClient(GoutteClient $client)
    {
        $this->client = $client;
        return $this;
    }

}