<?php
namespace BadPassword;

use Pleo\BloomFilter\BloomFilter;

class BadPassword{

public static function makeFilter()
{
	static $filter = null;
	if ($filter === null) {
		$filter = BloomFilter::initFromJson(
			json_decode(
				file_get_contents(
					__DIR__ . '/' . (PHP_INT_SIZE === 8 ? 'blacklist-x64.json' : 'blacklist-x86.json')
				),
				true
			)
		);
	}
	return $filter;
}

public static function isBad($password)
{
	return self::makeFilter()->exists($password);
}

}
