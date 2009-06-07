<?
    class Duckk_CommonDisplayAction extends Duckk_CommonAction
    {
        protected $who;
        
        public function __construct ($path, $pathParts = array ())
        {
            $this->pathParts = $pathParts;
            $this->data = array ();
            $this->path = $path;
            $this->setupActionInfo ($pathParts);
            $this->who = $pathParts[0];
            $this->dispatch ();            
        }
    }
?>