<?php

namespace WebExtractor\Test;

use WebExtractor\StashDriverFactory\StashDriverFactory;


/**
 * Class StashDriverFactoryTest
 *
 * @package WebExtractor\Test\Hander
 */
class StashDriverFactoryTest extends AbstractTestCase {
	private $factory;

    protected function setUp()
    {
        $this->factory = StashDriverFactory::getEntity();
    }

    public function testCreate() {
        $driver = $this->factory->createDriver("FileSystem");
        $this->assertInstanceOf('Stash\Driver\FileSystem', $driver);
    }

    public function testCreateCaseSensetivity() {
        $driver = $this->factory->createDriver("BlackHole");
        $this->assertInstanceOf('Stash\Driver\BlackHole', $driver);

        $driver = $this->factory->createDriver("blackhole");
        $this->assertInstanceOf('Stash\Driver\BlackHole', $driver);
    }

    /**
     * @expectedException     WebExtractor\StashDriverFactory\Exception\DriverNotFoundException
     */
    public function testCreateDriverNotFoundException() {
        $name = "myDriver";
        $this->factory->createDriver($name);
    }
}