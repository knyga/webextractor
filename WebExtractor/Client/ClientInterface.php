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

namespace WebExtractor\Client;

/**
 * The ClientInterface interface.
 *
 * @author Sobit Akhmedov <sobit.akhmedov@gmail.com>
 *
 * @packageWebExtractor\Client
 */
interface ClientInterface
{
    /**
     * Sends HTTP GET request.
     *
     * @param string $url URL to send request to
     * @param array  $params GET parameters to send along with the request
     *
     * @return string Content received
     */
    public function get($url, array $params = []);

    /**
     * Sends HTTP POST request.
     *
     * @param string $url    URL to send request to
     * @param array  $params POST parameters to send along with the request
     *
     * @return string Content received
     */
    public function post($url, array $params = []);

    /**
     * Gets meta data (headers) from url
     * @param  string $url
     * @param array  $params GET parameters to send along with the request
     * @return array
     */
    public function getMeta($url, array $params = []);
}
