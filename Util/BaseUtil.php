<?
	function arrayField ($objs, $field, $glue = null)
	{
	    $ret = array ();
	    foreach ($objs as $obj)
	    {
	        $ret[] = $obj-> $field;
	    }
	
	    return  ($glue) ? implode ($glue, $ret) : $ret;
	}
    
    function normalizeName ($name)
    {
        $name = preg_replace ("/'/", '', $name);
        $name = preg_replace ('/\W+/', ' ', $name);
        $name = preg_replace ('/\s+/', ' ', $name);
        $name = trim ($name);
        $name = preg_replace ('/\s/', '-', $name);
        return $name; 
    }
    
    function lcfirst ($str)
    {
        return strtolower(substr($str, 0, 1)) . substr($str, 1);
    }
    
    function dateAndTimeToSQL($date, $time)
    {
        //$num = cal_days_in_month(CAL_GREGORIAN, 8, 2003); // 31
        return date("Y-m-d H:i:s", strtotime("$date $time"));   
    }
    
    function currentSQLTime()
    {
        return date ("Y-m-d H:i:s", time());
    }
?>