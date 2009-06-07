<?
	class ClSearchOptions
	{
	    public $type;
	    public $cities;
	    public $clVars;
	    public $clType;
	    public $displaySearchStr;
	    public $q;
	    public $page;
	    
        public function __construct ($q = '', $type, $page = 1, $cities = array ())
        {
            if (empty ($type) || empty ($cities))
            {
                throw new Exception ('$type is required!');
            }
            
            if (empty ($cities))
            {
                $cities = CLUtil::getDefaultCities ();
            }
            
            $this->clVars = array ();
            $this->q = trim ($q);
            $this->type = $type;
            $this->cities = $cities;
            $this->page = (is_int ($page) && $page > 0) ? $page : 1;
            $this->parseQ ();
            $this->clType = CLUtil::getCLType ($this->type);
        }
        
        private function parseQ ()
        {
            if (empty ($this->q) || $this->q == '*')
            {
                $this->displaySearchStr = CLUtil::getLabelForType ($this->type);
                $this->clVars['query'] = null;                
            }
            else
            {
                $tokens = StringUtil::tokenize ($this->q);
                $qParts = array ();
                
                foreach ($tokens as $token)
                {
                    if (preg_match ('/^(srchType|minAsk|maxAsk|hasPic|addTwo):(.*)/i', $token, $matches))
                    {
                        $this->clVars[strtolower ($matches[1])] = $matches[2];
                    }
                    else
                    {
                        $qParts[] = $token;
                    }
                }

                $this->displaySearchStr = implode (' ' , $qParts);
                $this->clVars['query'] = trim (preg_replace ('/ {2,}/', ' ', strtolower (implode (' ' , $qParts))));
            }
        }
	}
?>