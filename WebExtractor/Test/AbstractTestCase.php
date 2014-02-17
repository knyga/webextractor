<?php

namespace WebExtractor\Test;

/**
 * Class AbstractTestCase
 *
 * @package WebExtractor\Test
 */
class AbstractTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\WebExtractor\Config\Config
     */
    protected function createConfigStub()
    {
        return $this->getMock('\DotConfig\Config', [], [], '', false);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    protected function createEventDispatcherStub()
    {
        return $this->getMock('\Symfony\Component\EventDispatcher\EventDispatcherInterface');
    }
}
