<?
	class ErrorUtil
	{
	    public static $ERRORS = array (
	               1 => 
    	               'Sorry, I was unable to display that ad. There\'s a few reasons this could happen:
    	               <ol>
    	               <li>The craigslist listing expired.</li>
    	               <li>You need to <a href="javascript: showCityDialog();">search more cities</a>.</li>
    	               <li>The listing is old.</li></oL>' 
	           );
	    
	    public static function getError ($code)
	    {
            $a = self::$ERRORS;
            return $a[$code];
	    }
	}
?>