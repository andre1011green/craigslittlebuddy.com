<?
	class UrlUtil
	{
	    public static function redirect ($url, $perm = false)
	    {
	        if ($perm) header ("HTTP/1.1 301 Moved Permanently");
	        header ("Location: $url");
	        exit;
	    }
	    
	    public static function redirectPerm ($url)
	    {
            self::redirect ($url, true);
	    }
	    
	    public static function complete ($url, $defaultProtocol = 'http://')
	    {
	    	return (! preg_match ('/^https*:\/\//', $url))
	    			? "{$defaultProtocol}{$url}"
					: $url;
	    }
	}
?>