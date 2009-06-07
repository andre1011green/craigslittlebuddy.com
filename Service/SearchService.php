<?
	define ("SEARCH_DATA_DIR", realpath ($_SERVER['DOCUMENT_ROOT'] . '../data/searchData'));
	require_once ('rss_fetch.inc');
	
	class SearchService
	{
		public $normalizedQuery;
		public $domains;
		public $searchOptions;
		public $allRss;
		public $countByDomain;
		
        const RSS_URL_FORMAT = 
                        //'http://pipes.yahoo.com/pipes/pipe.run?_id=85487649c521dc5494b94066141838ee&_render=rss&cityabbr=%s&category=%s&query=%s&srchType=%s&minAsk=%s&maxAsk=%s&hasPic=%s&addTwo=%s&format=rss';
            'http://%s.craigslist.org/search/%s?query=%s&srchType=%s&minAsk=%s&maxAsk=%s&hasPic=%s&addTwo=%s&format=rss';		

        const RSS_URL_FORMAT_EMPTY_QUERY = 
            //'http://pipes.yahoo.com/pipes/pipe.run?_id=f451bed7280f6f6e4e06ff5ee95b9d95&_render=rss&cityabbr=%s&category=%s';
            'http://%s.craigslist.org/%s/index.rss';
        
		public function __construct ($searchOptions)
		{
			$this->searchOptions = $searchOptions;
			$this->countByDomain = array ();
		}
		
		public function search ()
		{
			$this->allRss = $this->fetchRss ();
			return $this->allRss;
		}
		
		private function fetchRss ()
		{
			$allRss = array ();
			
			foreach ($this->searchOptions->cities as $d)
			{
			    $rss = fetch_rss ($this->getRssUrl ($d));
			    if ($rss)
			    {
                    $rss->clDomain = $d;
    			    $this->countByDomain[$d] = count ($rss->items);
    				$allRss[] = $rss;
			    }
			    else
			    {
			        $this->countByDomain[$d] = 0;
			    }
			}
			
			return $allRss;
		}
		
		private function getQueryKey ()
		{
			$optionsCopy = $this->searchOptions;
			$optionsCopy->clVars['query'] = SearchUtil::getKey ($this->searchOptions->clVars['query']);
			
			return
				$this->searchOptions->clType . 
				'/' . 
				md5 (serialize ($optionsCopy));
		}
		
		private function getRssUrl ($domain)
		{
		    $url = null;
		    $str = implode ('', $this->searchOptions->clVars);
		    
		    if (empty ($this->searchOptions->clVars['query']) && empty ($str))
		    {
                $url = sprintf (
                            self::RSS_URL_FORMAT_EMPTY_QUERY,
                            $domain,
                            @$this->searchOptions->clType);
		    }
		    else
		    {
    			$url = sprintf (
    						self::RSS_URL_FORMAT,
    						$domain,
    						$this->searchOptions->clType,
    						urlencode ($this->searchOptions->clVars['query']),
    						urlencode ($this->searchOptions->clVars['srchtype']),
    						urlencode ($this->searchOptions->clVars['minask']),
    						urlencode ($this->searchOptions->clVars['maxask']),
    						urlencode ($this->searchOptions->clVars['haspic']),
    						urlencode ($this->searchOptions->clVars['addtwo']));
		    }

            // echo '<!--' . $url . '-->', "\n";
            return $url;
		}
	}
?>
