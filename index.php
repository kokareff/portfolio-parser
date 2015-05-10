<?php

require __DIR__ . "/vendor/autoload.php";

use \Curl\Curl;
use Symfony\Component\DomCrawler\Crawler;

header("Content-type: text/plain");

class PortfolioImport
{
	private $mainUrl, $innerCurl;
	private $pageCache;

	function __construct($url)
	{
		$this->mainUrl = $url;
		$this->innerCurl = new Curl();

		if($response = $this->loadPage($url))
		{
			$pageCache[] = $response;
			$links = $this->getPages($response);

			if($links)
			{
				$dom = HtmlDomParser::str_get_html($links);
				
			}

			foreach($links as $lnk)
			{
				HtmlDomParser::str_get_html($lnk);
			}

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
		//print_r($dom->find(".text_box a"));

		if($page_links = $dom->find('.text_box a[href="*"]'))
		{
			return $page_links;
			//var_dump($dom->find('.text_box a["href"]'));
			//$links = array_unshift($page_links, $this->mainUrl);
			//return $links;
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