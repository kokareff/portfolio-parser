<?php

require __DIR__ . "/vendor/autoload.php";

use \Curl\Curl;
use Sunra\PhpSimple\HtmlDomParser;

header("Content-type: text/plain");

class PortfolioImport
{
	private $mainUrl, $innerCurl;

	function __construct($url)
	{
		$this->mainUrl = $url;
		$this->innerCurl = new Curl();

		if($response = $this->loadPage($url))
		{
			$links = $this->getPages($response);

			var_dump($links);

			$this->innerCurl->close();
		}
		else return false;
	}

	function loadPage($url)
	{
		$this->innerCurl->get($url);
		if($this->innerCurl->error)
		{
			$this->innerCurl->close();
			return false;
		}
		else
		{
			return $this->innerCurl->response;
		}
	}

	function getPages($pageContent)
	{
		$dom = HtmlDomParser::str_get_html($pageContent);

		if($page_links = $dom->find(".pages_list .text_box a"))
		{
			$links = array_unshift($page_links, $this->mainUrl);
			return $links;
		}
		else return false;
	}

	function getItemsList($items)
	{
		$dom = HtmlDomParser::str_get_html($items);
		$itemsList = $dom->find("#main_table .portfolio_container li");

		return $itemsList;
	}


}

$pfUrl = "http://www.weblancer.net/users/kokareff/portfolio/";

$pfImport = new PortfolioImport($pfUrl);

//$items = $pfImport->getItemsList($pfUrl);
//echo "<pre>";
//var_dump($items);
//echo "</pre>";