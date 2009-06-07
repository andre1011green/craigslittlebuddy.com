<?
    class Duckk_Template 
    {
        public $data;
        public $template;
        private $output;
        
        const TEMPLATE_DIR = 'templates/';
        const CONTENT_VAR = '__CONTENT__';
        
        public function __construct ($template = null, $data = array (), $wrapper = null)
        {
            $this->setData ($data);
            $this->setTemplate ($template);
            $this->setWrapper ($wrapper);
        }
        
        public function setTemplate ($template)
        {
            $this->template = $template;
        }
        
        public function setData ($data)
        {
            $this->data = $data;
        }        
        
        public function setWrapper ($wrapper)
        {
            $this->wrapper = $wrapper;
        }
        
        public function inc ($file, $additionalData = array ())
        {
        	$incData = (! empty ($additionalData)) ? array_merge ($this->data, $additionalData) : $this->data;
        	$t = new Duckk_Template ('inc/' . SKIN . "/{$file}", $incData);
        	$t->render ();
        }
                
        public function assign ($key, $value)
        {
            $this->data[$key] = $value;
        } 
        
        public function delete ($key)
        {
            unset ($this->data[$key]);   
        }
        
        public function render ($returnOutput = false)
        {
            extract ($this->data);
            ob_start ();
            
            $t = $this->getTemplatePath ();
            include ($t);
            $this->output = ob_get_clean ();
            
            if ($this->wrapper)
            {
                $data =& $this->data;
                $data[self::CONTENT_VAR] = $this->output;
                
                $wrapper = new Duckk_Template ('wrappers/' . SKIN . "/{$this->wrapper}", $data);
                $this->output = $wrapper->render (true);                
            }
            
            if ($returnOutput)
            {
                return $this->output;
            }
            else
            {
                echo $this->output;
            }
            
        }
        
        protected function getTemplatePath ()
        {
            return self::TEMPLATE_DIR . $this->template;
        }
    }
?>