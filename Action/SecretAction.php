<?
	class SecretAction extends Duckk_CommonAction 
	{
        public function secret ()
        {
            
        }
        
        public function phpinfo ()
        {
            if ($_GET['buddy'] != 9) exit;
            
            echo "<a href='phpinfo?buddy=9'>click</a>";
            
            DebugUtil::pre ($_SERVER);
            phpinfo ();
        }
        
        public function restoreCities ()
        {
            CookieUtil::kill (CookieUtil::KEY_CITIES);
            echo "done";
        }
        
        public function sf ()
        {
            $v = ($_GET['city']) ? $_GET['city'] : 'sfbay';
            CookieUtil::put (CookieUtil::KEY_CITIES, $v);
            echo "done";
        }        
	}
?>