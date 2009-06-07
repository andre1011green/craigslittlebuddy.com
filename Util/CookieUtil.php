<?
	class CookieUtil
	{
	    const KEY_CITIES = 'KEY_CITIES';
	    
	    public static function put ($key, $value, $expireTime = 0)
	    {
	        setcookie ($key, $value, $expireTime, '/');
	    }
	    
	    public static function get ($key)
	    {
	        return $_COOKIE[$key];
	    }
	    
	    public static function kill ($key)
	    {
	        setcookie ($key, null, time () - 1000, '/');
	    }
	}
?>