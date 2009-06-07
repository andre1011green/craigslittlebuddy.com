<?
/********************************************************************************************************
 * Lets figure out which ones the framework directories are
 * All directories that begin with a capital letter quality
 ********************************************************************************************************/
 	$frameworkDirectories = array ();
    if ($dh = opendir ("../")) 
    {
		while (($file = readdir ($dh)) !== false) 
		{
			if (preg_match ('/^[A-Z]/', $file))
			{
				$frameworkDirectories[] = $file;
			}
        }
        
        closedir ($dh);
    }
    
    define ("REGEX_PATTERN_FRAMEWORK_DIRS", implode ('|', $frameworkDirectories));
    
	/********************************************************************************************************
	 * object autoloader - used don't need to require anything
	 * Assumes non-matches are in the Framework directory
	 ********************************************************************************************************/
	spl_autoload_extensions ('.php');
	 
    function __autoload ($className)
    {
    	$includePath = null;
    	
    	if (strpos ($className, 'Duckk_') === 0)
    	{
    		$includePath = "Duckk/{$className}.php";
    	}
    	elseif (preg_match ('/^(.*)(' . REGEX_PATTERN_FRAMEWORK_DIRS . ')/', $className, $matches))
    	{
    		$includePath = "{$matches[2]}/{$matches[1]}{$matches[2]}.php";
    	}
		else
		{
    		$includePath = "Objects/{$className}.php";
		}
		
		include $includePath;
    }	    
?>