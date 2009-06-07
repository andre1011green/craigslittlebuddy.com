<?
	class Duckk_PathTranslate
	{
	    private $originalPath;
	    private $path;
	    
	    public function __construct ($originalPath)
	    {
	        $this->path = $this->originalPath = $originalPath;
            $this->doBefore ();
	        $this->translate ();
            $this->doAfter ();
	    }
	    
	    public function getTranslatedPath ()
	    {
	        return $this->path;
	    }
	    
	    private function doBefore ()
	    {
	        if ($this->path != '/')
	        {
	           $this->path = rtrim ($this->path, '/');
	        }
	    }
	    
        private function doAfter ()
        {
            
        }	    
	    
		public function translate ()
		{
	        if ($this->path == '/')
	        {
	            $this->path = "/home";
	            return;
	        }
	        
	        // custom search URL's
	        $types = array_keys (CLUtil::getLabelForType ());
	        $str = implode('|', $types);
	        if (preg_match ("/^\/($str)(.*)/i", $this->path, $matches))
	        {
	            $this->path = "/search/{$matches[1]}{$matches[2]}";
	            return;
	        }
	        else if (preg_match ('/^\/search(.*)/i', $this->path, $matches))  // generic search
	        {
	            $this->path = "/search/all{$macthes[0]}";
	            return;
	        }
		}	
	}
?>