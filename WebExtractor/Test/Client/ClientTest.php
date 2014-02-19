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

namespace WebExtractor\Test\Client;

use WebExtractor\Client\Client;
use WebExtractor\Test\AbstractTestCase;

/**
 * Class ClientTest
 *
 * @package WebExtractor\Test\Client
 */
class ClientTest extends AbstractTestCase
{
    /**
     * @var Client
     */
    private $client;

    protected function setUp()
    {
        $this->client = new Client($this->createConfigStub(), $this->createEventDispatcherStub());
    }

    public function testInterface()
    {
        $this->assertInstanceOf('\WebExtractor\Client\ClientInterface', $this->client);
    }

    /**
     * @group functional
     */
    public function testGet()
    {
        $url    = 'http://httpbin.org/get';
        $json   = $this->client->get($url);
        $parsed = json_decode($json, true);

        $this->assertNotNull($parsed);
        $this->assertTrue(is_array($parsed));

        $this->assertArrayHasKey('url', $parsed);
        $this->assertEquals($url, $parsed['url']);
    }

    /**
     * @group functional
     */
    public function testGetParams()
    {
        $url    = 'http://httpbin.org/get';
        $params = array('oleksandr' => 'knyga');
        $json   = $this->client->get($url, $params);
        $parsed = json_decode($json, true);

        $this->assertEquals($params['oleksandr'], $parsed['args']['oleksandr']);
    }

    /**
     * @group functional
     */
    public function testPost()
    {
        $url    = 'http://httpbin.org/post';
        $params = [
            'username' => 'foo',
            'password' => 'bar',
        ];

        $json   = $this->client->post($url, $params);
        $parsed = json_decode($json, true);

        $this->assertNotNull($parsed);
        $this->assertTrue(is_array($parsed));

        $this->assertArrayHasKey('url', $parsed);
        $this->assertEquals($url, $parsed['url']);

        $this->assertArrayHasKey('form', $parsed);
        $this->assertEquals($params, $parsed['form']);
    }

    public function testGetMeta() {
        $url = 'http://code.jquery.com/jquery-1.11.0.min.js';
        $meta = $this->client->getMeta($url);

        $this->assertEquals(96381, intval($meta['content-length']));
    }

    /**
     * @expectedException   \WebExtractor\Exception\HttpErrorException
     */
    public function test404Meta() {
        $url = 'http://urlnotexists.com/nono';
        $meta = $this->client->getMeta($url);
    }
}
