<?php

require "vendor/autoload.php";

use \Curl\Curl;

class PortfolioImport
{
	/* our inner Curl */
	$curl = new Curl();

	function getItemsList($url)
	{
		$curl->get(

		return $itemsList;
	}
}

$pfUrl = "http://www.weblancer.net/users/kokareff/portfolio/";

$pfImport = new PortfolioImport();

$pfImport->getItemsList($pfUrl);