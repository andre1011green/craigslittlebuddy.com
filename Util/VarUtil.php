<?
	class VarUtil
	{
	    public static function getFormVars ()
	    {
	        if (! empty ($_POST))
	        {
	            return $_POST;
	        }
	        elseif (! empty ($_GET))
	        {
	            return $_GET;
	        }
	        
	        return null;
	    }
	    
    	public static function isAssoc ($array)
        {
            return is_array ($array) && ! is_numeric (implode (array_keys ($array)));
        }
        
        // trim all _POST and _GET vars sp we dont have to do it ever again
        public static function trim_GET_POST ()
        {
            $cleanMe = array ('_GET', '_POST');
            
            foreach ($cleanMe as $method)
            {
                if (! empty ($$method))
                {
                    foreach ($$method as $k => $v)
                    {
                        if (is_array ($$method[$k]))
                        {
                            $count = count ($$method[$k]);
                        
                            for ($i = 0; $i < $count; $i++)
                            {
                                $$method[$k][$i] = trim ($$method[$k][$i]);
                            }
                        }
                        else
                        {
                            $$method[$k] = trim ($v);
                        }    
                    }
                }
            }
        }
        
        public static function makeAssocFromObject ($object)
        {
            $rtn = array ();
            $props = get_class_vars (get_class ($object));
            
            foreach ($props as $k => $v)
            {
                $rtn[$k] = $object->$k;    
            }
            
            return $rtn;    
        }
        
        public static function bindToObject ($assoc, &$obj)
        {
        	foreach ($assoc as $k => $v)
        	{
        		$obj->$k = $v;		
        	}
        }	    
	    
	}
?>