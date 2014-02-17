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

namespace WebExtractor\Test\Client\Decorator;

use WebExtractor\Client\Decorator\ClientResponseCacheDecorator;
use WebExtractor\Test\AbstractTestCase;
use Stash\Driver\Ephemeral;

/**
 * Class ClientResponseCacheDecoratorTest
 *
 * @package WebExtractor\Test\Client\Decorator
 */
class ClientResponseCacheDecoratorTest extends AbstractTestCase
{
    /**
     * @var ClientResponseCacheDecorator
     */
    private $decorator;

    protected function setUp()
    {
        $this->decorator = new ClientResponseCacheDecorator($this->createClientStub(), $this->createConfigStub(), $this->createEventDispatcherStub());
    }

    public function testInterface()
    {
        $this->assertInstanceOf('\WebExtractor\Client\ClientInterface', $this->decorator);
    }

    public function testSetDriverSetsPoolDriverAsWell()
    {
        $driverStub = $this->createDriverStub();
        $this->decorator->setDriver($driverStub);

        $pool = $this->decorator->getPool();
        $this->assertEquals($pool->getDriver(), $this->decorator->getDriver());
    }

    public function testGetRequestsBeingCached()
    {
        $client = $this->createClientStub();
        $client
            ->expects($this->once())
            ->method('get')
            ->will($this->returnValue('test content'))
        ;

        $decorator = new ClientResponseCacheDecorator($client, $this->createConfigStub(), $this->createEventDispatcherStub());
        //The data stored is for a short duration as specified by its TTL
        $decorator->setDriver(new Ephemeral());

        $decorator->get('test url');
        $decorator->get('test url');
        $decorator->get('test url');
    }

    public function testGetMetaRequestsBeingCached() {
        $client = $this->createClientStub();
        $client
            ->expects($this->once())
            ->method('getMeta')
            ->will($this->returnValue('test content'))
        ;

        $decorator = new ClientResponseCacheDecorator($client, $this->createConfigStub(), $this->createEventDispatcherStub());
        //The data stored is for a short duration as specified by its TTL
        $decorator->setDriver(new Ephemeral());

        $decorator->getMeta('test url');
        $decorator->getMeta('test url');
        $decorator->getMeta('test url');
    }

    public function testPostRequestsBeingCached()
    {
        $client = $this->createClientStub();
        $client
            ->expects($this->once())
            ->method('post')
            ->will($this->returnValue('test content'))
        ;

        $decorator = new ClientResponseCacheDecorator($client, $this->createConfigStub(), $this->createEventDispatcherStub());
        $decorator->setDriver(new Ephemeral());

        $decorator->post('test url', ['foo' => 'bar']);
        $decorator->post('test url', ['foo' => 'bar']);
        $decorator->post('test url', ['foo' => 'bar']);
    }

    public function testPostRequestNotBeingCachedWithDifferentParams()
    {
        $client = $this->createClientStub();
        $client
            ->expects($this->exactly(3))
            ->method('post')
            ->will($this->returnValue('test content'))
        ;

        $decorator = new ClientResponseCacheDecorator($client, $this->createConfigStub(), $this->createEventDispatcherStub());
        $decorator->setDriver(new Ephemeral());

        $decorator->post('test url', ['foo1' => 'bar1']);
        $decorator->post('test url', ['foo2' => 'bar2']);
        $decorator->post('test url', ['foo3' => 'bar3']);
    }

    public function testPostRequestBeingCachedWithSameParamsButDifferentOrder()
    {
        $client = $this->createClientStub();
        $client
            ->expects($this->once())
            ->method('post')
            ->will($this->returnValue('test content'))
        ;

        $decorator = new ClientResponseCacheDecorator($client, $this->createConfigStub(), $this->createEventDispatcherStub());
        $decorator->setDriver(new Ephemeral());

        $decorator->post('test url', ['foo1' => 'bar1', 'foo2' => 'bar2', 'foo3' => 'bar3']);
        $decorator->post('test url', ['foo2' => 'bar2', 'foo3' => 'bar3', 'foo1' => 'bar1']);
        $decorator->post('test url', ['foo3' => 'bar3', 'foo1' => 'bar1', 'foo2' => 'bar2']);
    }



    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\WebExtractor\Client\ClientInterface
     */
    private function createClientStub()
    {
        return $this->getMock('\WebExtractor\Client\ClientInterface');
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Stash\Interfaces\DriverInterface
     */
    private function createDriverStub()
    {
        return $this->getMock('\Stash\Interfaces\DriverInterface');
    }
}
