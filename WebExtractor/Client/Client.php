<?php

namespace WebExtractor\Client;

use Diggin\Bridge\Guzzle\AutoCharsetEncodingPlugin\AutoCharsetEncodingPlugin;
use Goutte\Client as GoutteClient;
use DotConfig\Config;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * The Client class is the base class of MizzleParser. It is a wrapper of {@see \Goutte\Client} which implements
 * {@see \WebExtractor\Client\ClientInterface}.
 *
 * @author Sobit Akhmedov <sobit.akhmedov@gmail.com>
 *
 * @package WebExtractor\Client
 */
class Client implements ClientInterface
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var GoutteClient
     */
    private $client;

    /**
     * @param Config                   $config
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(Config $config = null, EventDispatcherInterface $eventDispatcher = null)
    {
        $this->config          = $config;
        $this->eventDispatcher = $eventDispatcher;
    }

    private function createGetUrl($url, array $params = []) {
        if(count($params) > 0) {
            $query = http_build_query($params);
            $url .= '?' . $query;
        }

        return $url;
    }

    /**
     * Sends HTTP GET request.
     *
     * @param string $url URL to send request to
     * @param array  $params GET parameters to send along with the request
     *
     * @return string Content received
     */
    public function get($url, array $params = [])
    {
        $url = $this->createGetUrl($url, $params);
        $this->getClient()->request('get', $url);

        return $this->getClient()->getInternalResponse()->getContent();
    }

    /**
     * Sends HTTP POST request.
     *
     * @param string $url    URL to send request to
     * @param array  $params POST parameters to send along with the request
     *
     * @return string Content received
     */
    public function post($url, array $params = [])
    {
        $this->getClient()->request('post', $url, $params);

        return $this->getClient()->getInternalResponse()->getContent();
    }

    /**
     * Returns original {@see \Goutte\Client} client.
     *
     * If not set, creates new instance and sets
     * {@see \Diggin\Bridge\Guzzle\AutoCharsetEncodingPlugin\AutoCharsetEncodingPlugin} to support various charsets.
     *
     * @return GoutteClient
     */
    public function getClient()
    {
        if (null === $this->client) {
            $this->client = new GoutteClient();
            $this->client->getClient()->addSubscriber(new AutoCharsetEncodingPlugin());
        }

        return $this->client;
    }

    /**
     * Sets client.
     *
     * @param GoutteClient $client
     */
    public function setClient(GoutteClient $client)
    {
        $this->client = $client;
    }

    /**
     * Gets meta data (headers) from url
     * @param  string $url
     * @param array  $params GET parameters to send along with the request
     * 
     * @return array
     */
    public function getMeta($url, array $params = []) {
        $url = $this->createGetUrl($url, $params);
        $data = array();
        
        $file = fopen($url,"r");
        $meta = stream_get_meta_data($file);
        fclose($file);

        foreach($meta["wrapper_data"] as $m) {
            $kv = explode(":",$m);
            $length = count($kv);

            switch($length) {
                case 1:
                    $kv = explode('/', $m);
                case 2:
                    $key = trim(strtolower($kv[0]));
                    $value = trim($kv[1]);
                    $data[$key] = $value;
                break;
            }
        }

        return $data;
    }
}
