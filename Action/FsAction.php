<?
    class FsAction extends SearchAction
    {
        public $i;
        public $result;
        public $permalink;        
        
        public function fs ()
        {
            $this->q = trim ($_GET['q']);
            $this->searchOptions = $this->getSearchOptions ();
            $this->sort = htmlentities ($_REQUEST['sort']);
            $this->setupPerf ();
            $this->getSearchResults ();
            $this->result = $this->findResult ($this->permalink);
            
            if (! empty ($this->searchResults[$this->i]))
            {
                $this->result = $this->searchResults[$this->i];
                $this->prevResult = $this->searchResults[$this->i - 1];
                $this->nextResult = $this->searchResults[$this->i + 1];
                $this->setupMeta ();
                $this->render (null);
            }
            else
            {
                $this->render404 ();
            }
        }
        
        protected function getSearchResults ()
        {
            $searchService = new SearchService ($this->searchOptions);
            $results = $searchService->search ();
            
            foreach ($results as $rss)
            {
                $this->searchResults = array_merge($this->searchResults, $rss->items);
            }
            
            $this->totalResults = count ($this->searchResults);
            
            if ($this->totalResults > 0)
            {
                $this->sort ($this->sort);
            }
        }       
        
        protected function setupVars ()
        {
            parent::setupVars ();
            $this->searchType = htmlentities ($_GET['type']);
            $this->permalink = urldecode ($_GET['p']);
        }
        
        protected function findResult ($p)
        {
            $num = count ($this->searchResults);
            for ($i = 0; $i < $num; $i++)
            {
               if ($this->searchResults[$i]['link'] == $this->permalink)
               {
                   $this->i = $i;
                   return $this->searchResults[$i]; 
               }
            }
            
            return null;
        }        
        
        protected function setupMeta ()
        {
            $this->meta['title'] = $this->result['title'];
        }
    }
?>