<?
    class Duckk_CommonAction extends Duckk_Action
    {
        protected $action;
        protected $detail;
        protected $pathParts;
        protected $path;
        protected $basePath;
        protected $template;
        protected $data;
        
        public $meta;
        
        function Duckk_CommonAction ($path, $pathParts = array ())
        {
        	$this->pathParts = $pathParts;
            array_unshift ($pathParts, '_');	// TODO: hack
            $this->data = array ();
            $this->path = $path;
            $this->setupActionInfo ($pathParts);
            $this->dispatch ();
        }
        
        public function getDispatch ()
        {
       		return StringUtil::lcFirst ($this->action); 	
        }
        
        // TODO: make this work with other classes
        protected function forward ($forwardTo)
        {
            $rtn = null;
            $args = func_get_args ();
            $paramsToForward = array_slice (func_get_args (), 1);
            $this->action = $forwardTo;
            $argStr = implode (', ', $paramsToForward);
            eval ("\$rtn = \$this->\$forwardTo ($argStr);");
            return $rtn;
        }
        
        protected function setupActionInfo ($pathParts)
        {
            $this->meta = array ();
            
            $this->action = (! empty ($pathParts[1])) 
            				? $pathParts[1] 
            				: preg_replace ('/Action$/', '', get_class ($this));
			
			$this->basePath = preg_replace ("/\/$this->action\$/", '', $this->path); 

            if (! method_exists ($this, $this->action))
            {
                $this->render404 ();
                return;
            }
            elseif (! is_callable (array ($this, $this->action)))
            {
                $this->render500 ();
                return;            	
            }
            
            $this->template = new Duckk_Template (null, $this->data);
            if (! empty ($pathParts[2])) $this->detail = $pathParts[2];
        }
        
        protected function dispatch ()
        {
            $this->setupVars ();
            $action = $this->action;
            
            if ($this->checkAccess () === false) return $this->render403 ();
        }
        
        protected function render ($wrapper = 'chrome.php')
        {
        	$path = preg_replace ('/Action$/', '', StringUtil::lcFirst (get_class ($this)))
					. '/' 
					. $this->getDispatch () 
					. '.php';
        		
			$this->template->setTemplate ($this->getTemplatePath ($path, 'action'));
			$this->template->setWrapper ($wrapper);
			$this->template->data = get_object_vars ($this);        				
			$this->template->render ();
        }
        
        protected function getTemplatePath ($path, $type = 'common')
        {
            return "{$type}/" . SKIN . "/{$path}";
        }
        
        protected function render403 ()
        {
	        header ('HTTP/1.0 403 Unauthorized');
            $t = new Duckk_Template ('status/403.php', array ('url' => $_SERVER['REQUEST_URI']));
            $t->render ();   
        }
                
        public function render404 ()
        {        
        	header ('HTTP/1.0 404 Not Found');
        	
        	$data = array ('url' => $_SERVER['REQUEST_URI']);
        	$data['q'] = $_REQUEST['q'];
        	$data['searchOptions'] = CLUtil::getSearchOptions($_GET['type'], $_GET['q']);
        	
            $data['meta'] = array ('h1' => 'Page Not Found', 
                    'h2' => 'This craigslist ad may have been removed.');
            
            $data['sections'] = CLUtil::getLabelForType ();
            asort ($data['sections']);
                        
            $t = new Duckk_Template ('status/404.php', $data);
            
            $t->setWrapper ('chrome.php');
            $t->render ();   
        }
        
        public static function render500 ()
        {
        	header ('HTTP/1.0 500 Internal Server Error');
            $t = new Duckk_Template ('status/500.php', array ('url' => $_SERVER['REQUEST_URI']));
            $t->render ();   
        }        
        
        protected function setupVars () {}
        protected function checkAccess () {}
    }
?>