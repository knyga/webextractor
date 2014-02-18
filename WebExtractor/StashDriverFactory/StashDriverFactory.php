<?php

namespace WebExtractor\StashDriverFactory;

use WebExtractor\StashDriverFactory\Exception\DriverNotFoundException;

use Stash\Driver\Apc;
use Stash\Driver\BlackHole;
use Stash\Driver\Composite;
use Stash\Driver\Ephemeral;
use Stash\Driver\FileSystem;
use Stash\Driver\Memcache;
use Stash\Driver\Sqlite;
use Stash\Driver\Xcache;

use Stash\Interfaces\DriverInterface;

/**
 * The StashDriverFactory initializes Stash Driver
 * https://github.com/tedivm/Stash/tree/master/src/Stash/Driver
 *
 * @author Oleksandr Knyga <oleksandrknyga@gmail.com>
 */
class StashDriverFactory {
	const APC = "apc";
	const BLACKHOLE = "blackhole";
	const COMPOSITE = "composite";
	const EPHEMERAL = "ephemeral";
	const FILESYSTEM = "filesystem";
	const MEMCACHE = "memcache";
	const REDIS = "redis";
	const SQLITE = "sqlite";
	const XCACHE = "xcache";

	private static $entity;
	private function __construct(){}
	public static function getEntity() {

		if(!static::$entity) {
			static::$entity = new StashDriverFactory;
		}

		return static::$entity;
	}

	/**
	 * @param  string $name
	 * @param  array $options
	 * 
	 * @return DriverInterface
	 * @throws DriverNotFoundException
	 */
	public function createDriver($name, $options = array()) {
		$name = strtolower($name);

		if(!is_array($options)) {
			$options = array();
		}

		switch($name) {
			case static::APC:
				return new Apc($options);
			break;

			case static::BLACKHOLE:
				return new BlackHole($options);
			break;

			case static::EPHEMERAL:
				return new Ephemeral($options);
			break;

			case static::FILESYSTEM:
				return new FileSystem($options);
			break;

			case static::MEMCACHE:
				return new Memcache($options);
			break;

			case static::REDIS:
				return new Redis($options);
			break;

			case static::SQLITE:
				return new Sqlite($options);
			break;

			case static::XCACHE:
				return new Xcache($options);
			break;

			default:
				throw new DriverNotFoundException;
		}


	}

}