<?
	class BrowseResultsAction extends FsAction
	{
	    public $i;
	    public $result;
	    public $permalink;
	    
	    public function browseResults ()
	    {
            $this->q = trim ($_GET['q']);
            $this->searchType = htmlentities ($_GET['type']);
            $this->searchOptions = $this->getSearchOptions ();
            if (! empty ($this->cities)) $this->searchOptions->cities = $this->cities;
            $this->sort = htmlentities ($_REQUEST['sort']);
            $this->setupPerf ();
            $this->getSearchResults ();
            
            $this->result = $this->findResult ($this->permalink);
            
            if (! empty ($this->result))
            {
                $this->setupMeta ();
                $this->render ('browseFrame.php');
            }
            else
            {
                if ($this->searchOptions->type)
                {
                    UrlUtil::redirect ('/'
                                . urlencode ($this->searchOptions->type)
                                . '?q='
                                . urlencode ($this->searchOptions->q)
                                . '&e=1', ($_GET['p'] && ! $permaLinkOK));
                    exit;
                }
                else
                {
                    $this->render404 ();
                }
            }
	    }
	    
        protected function setupVars ()
        {
            parent::setupVars ();
            
            preg_match ('/http:\/\/(\w+)\./', $this->permalink, $matches);
            $this->injectNewCity ($matches[1]);
        }	    
        
        private function injectNewCity ($domain)
        {
            if (! $domain) return;

            $used = CLUtil::getUsedCities ();
            $found = array_search ($domain, $used);
            
            if ($found === false)
            {
                $used[] = $domain;
                sort ($used);
                $this->cities = $used;
                CLUtil::cookieDomains ($used);
            }
        }
	}
?>