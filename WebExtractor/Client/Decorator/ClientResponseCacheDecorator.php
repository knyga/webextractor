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

namespace WebExtractor\Client\Decorator;

use WebExtractor\Client\ClientInterface;
use DotConfig\Config;
use Stash\Driver\BlackHole;
use Stash\Interfaces\DriverInterface;
use Stash\Interfaces\ItemInterface;
use Stash\Interfaces\PoolInterface;
//Interface for operations with cache
use Stash\Pool;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * The ClientResponseCacheDecorator class wraps client and adds cache functionality while providing the same interface.
 *
 * @author Sobit Akhmedov <sobit.akhmedov@gmail.com>
 *
 * @package WebExtractor\Client\Decorator
 */
class ClientResponseCacheDecorator implements ClientInterface
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;

    /**
     * @var PoolInterface
     */
    private $pool;

    /**
     * @var DriverInterface
     */
    private $driver;

    /**
     * @var integer
     */
    private $ttl;

    /**
     * @param ClientInterface          $client
     * @param Config                   $config
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(ClientInterface $client, Config $config, EventDispatcherInterface $eventDispatcher)
    {
        $this->client          = $client;
        $this->config          = $config;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Sends HTTP GET request.
     *
     * If the response of this request is cached, returns cached copy instead.
     *
     * @param string $url URL to send request to
     * @param array  $params GET parameters to send along with the request
     *
     * @return string Content received
     */
    public function get($url, array $params = [])
    {
        /** @var ItemInterface $item */
        $item    = $this->getPool()->getItem($this->getRequestHash('get', $url, $params));
        $content = $item->get();

        if ($item->isMiss()) {
            $content = $this->client->get($url, $params);
            $item->set($content, $this->getTtl());
        }

        return $content;
    }

    /**
     * Sends HTTP POST request.
     *
     * If the response of this request is cached, returns cached copy instead.
     *
     * @param string $url    URL to send request to
     * @param array  $params POST parameters to send along with the request
     *
     * @return string Content received
     */
    public function post($url, array $params = [])
    {
        /** @var ItemInterface $item */
        $item    = $this->getPool()->getItem($this->getRequestHash('post', $url, $params));
        $content = $item->get();

        if ($item->isMiss()) {
            $content = $this->client->post($url, $params);
            $item->set($content, $this->getTtl());
        }

        return $content;
    }

    /**
     * Gets meta data (headers) from url
     * @param  string $url
     * @param array  $params GET parameters to send along with the request
     * 
     * @return array
     */
    public function getMeta($url, array $params = []) {
        /** @var ItemInterface $item */
        $item    = $this->getPool()->getItem($this->getRequestHash('meta', $url, $params));
        $data = $item->get();

        if ($item->isMiss()) {
            $data = $this->client->getMeta($url, $params);
            $item->set($data, $this->getTtl());
        }

        return $data;
    }

    /**
     * Returns cache pool.
     *
     * If cache pool is not set, creates new instance of it.
     *
     * @return PoolInterface
     */
    public function getPool()
    {
        if (null === $this->pool) {
            $this->pool = new Pool($this->getDriver());
        }

        return $this->pool;
    }

    /**
     * Sets cache pool.
     *
     * @param PoolInterface $pool
     *
     * @return ClientResponseCacheDecorator
     */
    public function setPool(PoolInterface $pool)
    {
        $this->pool = $pool;

        return $this;
    }

    /**
     * Gets cache driver.
     *
     * If cache driver is not set, creates new instance of it, which is {@see \Stash\Driver\BlackHole} by default.
     * BlackHole driver is the fake cache driver. Use {@see setDriver()} method to set the real one.
     *
     * @return DriverInterface
     */
    public function getDriver()
    {
        if (null === $this->driver) {
            $this->driver = new BlackHole();
        }

        return $this->driver;
    }

    /**
     * Sets cache driver.
     *
     * Updates pool driver as well.
     *
     * @param DriverInterface $driver
     *
     * @return ClientResponseCacheDecorator
     */
    public function setDriver(DriverInterface $driver)
    {
        $this->getPool()->setDriver($driver);
        $this->driver = $driver;

        return $this;
    }

    /**
     * Gets TTL of the cache.
     *
     * Default value is set in the config file.
     *
     * @return integer Cache TTL in seconds
     */
    public function getTtl()
    {
        if (null === $this->ttl) {
            $this->ttl = $this->config->get('client.cache.ttl');
        }

        return $this->ttl;
    }

    /**
     * Sets TTL of the cache.
     *
     * @param integer $ttl Cache TTL in seconds
     *
     * @return ClientResponseCacheDecorator
     */
    public function setTtl($ttl)
    {
        $this->ttl = $ttl;

        return $this;
    }

    /**
     * Returns unique request hash.
     *
     * Used as a cache key.
     *
     * @param string $method Request method
     * @param string $url    Request URL
     * @param array  $params Request params
     *
     * @return string
     */
    private function getRequestHash($method, $url, array $params = [])
    {
        ksort($params);

        return md5(sprintf('%s:%s:%s', $method, $url, serialize($params)));
    }
}
