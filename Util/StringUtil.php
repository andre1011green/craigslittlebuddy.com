<?
	class StringUtil
	{
	    public static function lcfirst ($str)
    	{
        	return strtolower (substr ($str, 0, 1)) . substr ($str, 1);
    	}
    	
        public static function tokenize ($string, $alpha = false)
        {
            $string = preg_replace ('/\s{2,}/', ' ', $string);
            for ($tokens = array(), $nextToken = strtok ($string, ' '); $nextToken !==false; $nextToken = strtok(' '))
            {        
                if ($nextToken{0} == '"')
                    $nextToken = $nextToken{strlen ($nextToken)-1} == '"' ? 
                        substr ($nextToken, 1, -1) : substr ($nextToken, 1) . ' ' . strtok ('"');
                        
                elseif ($nextToken{0} == "'")
                    $nextToken = $nextToken{strlen ($nextToken)-1} == "'" ? 
                        substr ($nextToken, 1, -1) : substr ($nextToken, 1) . ' ' . strtok ("'");
    
                $tokens[] = strstr ($nextToken, ' ') ? "\"$nextToken\"" : $nextToken;
            }
            
            if ($alpha) sort ($tokens);
            
            return $tokens;
        }    	
    	
	    public static function isValidEmail ($email)
	    {
	        if (! eregi ("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) 
	        { 
	            return false;
	        }
	        
	        return true; 
	    }    		
	}
?>