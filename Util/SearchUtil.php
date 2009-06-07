<?
	class SearchUtil
	{
	    static function getKey ($string)
	    {
	    	return (md5 (implode (StringUtil::tokenize ($string, true))));
	    }
	}
?>