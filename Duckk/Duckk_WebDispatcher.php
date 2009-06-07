<?
	class Duckk_WebDispatcher extends Duckk_Dispatcher
	{
		private $originalPath;
		private $path;
		
		public function __construct ($requestUrl)
		{
    		$this->originalPath = $requestUrl;
    		$this->translatePath ();
    		$this->setSkin ();
    		$action = $this->getAction ();
    		
    		if ($action)
    		{
    			$this->dispatch ($action);
    		}
    		else
    		{
    			$a = new Duckk_CommonAction ();
    			$a->render ();
    		}
		}
		
		protected function setSkin ()
		{
		    define ('SKIN', 'default');
		}
		
		protected function translatePath ()
		{
    		$translator = new Duckk_PathTranslate ($this->originalPath);
    		$this->path = $translator->getTranslatedPath ();
		}	
		
		protected function getAction ()
		{
		    $basePath = $class = null;
		    $pathParts = explode ('/', trim ($this->path, '/'));
		    $baseActionName = ucfirst (array_shift ($pathParts));
		    $actionName = $baseActionName . "Action";
		    
		    if (class_exists ($actionName, true) && is_callable (array ($actionName, $baseActionName), false))
		    {
		    	$class = $actionName;
		    }
		    elseif (! empty ($pathParts))
		    {
		    	$actionName = $baseActionName . ucfirst (array_shift ($pathParts)) . 'Action';
		    	if (class_exists ($actionName, true))
		    	{
		    		$class = $actionName;
		    	}
		    }
		    
		    if (! empty ($class))
		    {
                return new $class ($this->path, $pathParts);
		    }
		    else
		    {
                return false;
		    }
		}
		
		protected function dispatch (Duckk_Action $action)
		{
			$dispatch = $action->getDispatch ();
		    $action->$dispatch ();
		}
	}
?>