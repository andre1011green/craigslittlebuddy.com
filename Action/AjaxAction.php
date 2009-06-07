<?
	class AjaxAction extends Duckk_CommonAction 
	{
	    public function ajax ()
	    {
	    }
	    
	    public function saveCityConfig ()
	    {
	        $domains = array_keys ($_POST['city']);
	        
	        if (! empty ($domains))
	        {
                CLUtil::cookieDomains ($domains);
	        }
	    }
	}
?>