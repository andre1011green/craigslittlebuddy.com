<?
	class SearchAction extends Duckk_CommonDisplayAction 
	{
	    protected $searchType;
	    
	    public $searchOptions;
	    public $sort;
	    public $searchResults;
	    public $page;
	    public $totalResults;
	    public $displayLastItem;
	    public $displayOffset;
	    public $errorCode;

	    const SORT_CITY = 'city';
	    const SORT_TIME_LATEST = '';
	    const SORT_TIME_OLDEST = 'oldest';
	    const SORT_PRICE_LOWEST = 'priceLow';
	    const SORT_PRICE_HIGHEST = 'priceHigh';
	    const SORT_DEFAULT = self::SORT_TIME_LATEST;
	    
	    const MAX_RSS_TIME = 320;
	    
	    const RESULTS_PER_PAGE = 100;
	    
	    public $sortOptions = array (
	                       self::SORT_CITY => 'City',
	                       self::SORT_PRICE_HIGHEST => 'Price: highest first',
	                       self::SORT_PRICE_LOWEST => 'Price: lowest first',
	                       self::SORT_TIME_LATEST => 'Time: newest',
	                       self::SORT_TIME_OLDEST => 'Time: oldest');
	    
	    public function search ()
	    {
	        $this->q = trim ($_GET['q']);
	        $this->searchOptions = $this->getSearchOptions ();
	        $this->sort = htmlentities ($_REQUEST['sort']);
	        $this->setupPerf ();
	        $this->getSearchResults ();
	        $this->setupMeta ();
	        $this->errorCode = $_REQUEST['e'];
	        
	        if ($this->totalResults)
	        {
	           $this->render ();
	        }
	        else
	        {
	            $this->forward ('noResults');
	        }
	    }
	    
	    protected function setupPerf ()
	    {
	        $num = count ($this->searchOptions->cities);
	        $num = ($num) ? $num : 22;
	        set_time_limit (0);
	        ini_set ('memory_limit', $num * 2.1 . 'M');
	        
	        if ($num > 25) define ('MAGPIE_FETCH_TIME_OUT', ceil (self::MAX_RSS_TIME / $num));
	    }
	    
	    protected function noResults ()
	    {
	        $this->render ();
	    }
	    
	    protected function setupMeta ()
	    {
	        $numResults = number_format ($this->totalResults);
	        
	        $this->meta['subLogoText'] = ($this->searchType != 'search')
	                       ? CLUtil::getLabelForType ($this->searchType) . ' for sale'
	                       : TextUtil::getRandomPhrase ();
	        
	        $this->meta['h1'] = $this->searchOptions->displaySearchStr . (empty ($this->q) && $this->searchType != 'wtb' ? ' for sale on craigslist' : ''); 
            $this->meta['h2-addon'] = '<a id="showCityDialogLink2" href="javascript: void (null)">search more cities</a>';	                       
	        
	        if (! empty ($this->q))
	        {
    	        $this->meta['h2'] = $numResults 
    	                               . " search results for \"{$this->searchOptions->displaySearchStr}\" from " 
    	                               . count ($this->searchOptions->cities)
    	                               . ' craigslist cities';
	        }
	        else
	        {
                $this->meta['h2'] = $numResults 
                                       . " results in "
                                       . CLUtil::getLabelForType ($this->searchOptions->type) 
                                       . " from "
                                       . count ($this->searchOptions->cities)
                                       . ' craigslist cities';                                       	            
	        }
            
	        $this->meta['title'] = ($this->searchType != 'wtb')
	                           ? $this->searchOptions->displaySearchStr . ' for sale on craigslist'
	                           : 'WTB listings for ' . $this->searchOptions->displaySearchStr . ' on craigslist';
	        
            $this->meta['description'] = ($this->searchType != 'wtb')
                                ? "$numResults search results from " . count ($this->searchOptions->cities) . " craigslist cities."
                                : "$numResults WTB listings from  " . count ($this->searchOptions->cities) . ' craigslist cities.';

            $this->meta['description'] .= " Craig's Little Buddy helps you search craigslist. Search multiple cities, sort listings. Results updated constantly.";                                
	                               
            $this->meta['keywords'] = ($this->searchType != 'wtb')
                                ? $this->searchOptions->displaySearchStr . ', for sale, craigslist, classifieds, classified ad'
                                : $this->searchOptions->displaySearchStr . ', wtb, craigslist, classifieds, classified ads, want to buy';
                                
            if (empty ($this->q) && $this->searchOptions->type == 'search')
            {
                $this->meta['h2'] = $numResults . " search results from " . count ($this->searchOptions->cities) . ' craigslist cities';
                $this->meta['h1'] = 'For Sale on Craigslist';
                $this->meta['title'] = 'For Sale on Craigslist';
                $this->meta['description'] = 'Classified listings on craigslist.';
                $this->meta['keywords'] = 'search, for sale, craigslist, classifieds, classified ads';
            }
	    }
	    
	    protected function getSearchOptions ()
	    {
            return CLUtil::getSearchOptions ($this->searchType, $_GET['q'], 
                                $this->getPage (), CLUtil::getUsedCities());
	    }
	    
	    protected function getPage ()
	    {
	        $this->page = (intval ($_GET['page']) && $_GET['page'] > 0) ? $_GET['page'] : 1;
	        return $this->page;
	    }
	    
	    protected function getSearchResults ()
	    {
            $searchService = new SearchService ($this->searchOptions);
            $results = $searchService->search ();
            $this->countByDomain = $searchService->countByDomain; 
            
            foreach ($results as $rss)
            {
                $this->searchResults = array_merge($this->searchResults, $rss->items);
            }
            
            $this->totalResults = count ($this->searchResults);
            
            if ($this->totalResults > 0)
            {
                $this->sort ($this->sort);
            }
            
            $this->setupPageResults ();
	    }
	    
	    protected function setupPageResults ()
	    {
	        $this->getPage ();
            $offset = (($this->page * self::RESULTS_PER_PAGE) - self::RESULTS_PER_PAGE);
            $this->searchResults = array_slice ($this->searchResults, $offset, self::RESULTS_PER_PAGE);
            $this->displayLastItem = (count ($this->searchResults)) + $offset; 
            $this->displayOffset = $offset + 1;
	    }
	    
	    public function goto ()
	    {
            $this->searchType = $_GET['section'];
            $this->q = trim ($_GET['q']);
            $this->searchOptions = $this->getSearchOptions ();
            $this->sort = $_REQUEST['sort'];
            $this->setupPerf ();
            $this->getSearchResults ();
            
            $numToSkip = 0;
            foreach ($this->countByDomain as $k => $v)
            {
                if ($k == $_GET['city']) break;
                $numToSkip += $v;                            
            }
            
            $page = (floor ($numToSkip / self::RESULTS_PER_PAGE)) + 1;
            $url = "/{$this->searchType}?q=" . urlencode ($this->q) . "&sort=" . self::SORT_CITY . (($page != 1) ? "&page={$page}" : '' ) ."#{$_GET['city']}";
            UrlUtil::redirect ($url);
	    }
	    
	    protected function getPageOffset ()
	    {
            return $offset;
	    }
	    
	    protected function sort ($sort)
	    {
            switch ($sort)
            {
                case self::SORT_PRICE_HIGHEST :
                    usort ($this->searchResults, array ('self', 'sortByHighPrice'));
                    break;                                        
                case self::SORT_CITY :
                    usort ($this->searchResults, array ('self', 'sortByCity'));
                    break;                    
                case self::SORT_PRICE_LOWEST :
                    usort ($this->searchResults, array ('self', 'sortByLowPrice'));
                    break;            
                case self::SORT_TIME_LATEST :
                    usort ($this->searchResults, array ('self', 'sortByLatest'));
                    break;
                case self::SORT_TIME_OLDEST :
                    usort ($this->searchResults, array ('self', 'sortByOldest'));
                    break;                 
                default :
                    usort ($this->searchResults, array ('self', 'sortByLatest'));
                    break;                                 
            }
	    }

	    protected function sortByLowPrice ($a, $b)
        {
            if ((int) $a['clb']['price'] == (int) $b['clb']['price']) 
            {
                return 0;
            }
            
            return ((int) $b['clb']['price'] > (int) $a['clb']['price']) ? -1 : 1;
        }
        
        protected function sortByHighPrice ($a, $b)
        {
            if ((int) $a['clb']['price'] == (int) $b['clb']['price']) 
            {
                return 0;
            }
            
            return ((int) $b['clb']['price'] < (int) $a['clb']['price']) ? -1 : 1;
        }        
        
        protected function sortByOldest ($a, $b)
        {
            if ($a['clb']['unixtime'] == $b['clb']['unixtime']) 
            {
                return 0;
            }
            
            return ($b['clb']['unixtime'] > $a['clb']['unixtime']) ? -1 : 1;
        }
        	    
	    protected function sortByLatest ($a, $b)
	    {
            if ($a['clb']['unixtime'] == $b['clb']['unixtime']) 
            {
                return 0;
            }
            
            return ($b['clb']['unixtime'] < $a['clb']['unixtime']) ? -1 : 1;
	    }
	    
        protected function sortByCity ($a, $b)
        {
            if ($a['clb']['clDomain'] == $b['clb']['clDomain']) 
            {
                return ($b['clb']['unixtime'] < $a['clb']['unixtime']) ? -1 : 1;
            }
            else
            {
                return strcmp ($a['clb']['clDomain'], $b['clb']['clDomain']);
            }
        }	    
	    
	    protected function setupVars ()
	    {
	        $this->searchResults = array ();
	        $this->countByDomain = array ();
	        $this->searchType = strtolower ($this->who);
	    }
	}
?>