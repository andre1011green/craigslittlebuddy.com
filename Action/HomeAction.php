<?
	class HomeAction extends Duckk_CommonAction
	{
	    public $q;
	    public $sections;
	    
        public function home ()
        {
            $this->q = $_GET['q'];
            $this->meta['title'] = 'Helping You Search Craigslist - Craig\'s Little Buddy';
            $this->meta['description'] = 'A better way to find stuff on craigslist: Search multiple craigslist cities at the same time, sort and browser results.';
            $this->meta['keywords'] = 'craigslist, search, craigslist search, for sale, WTB';
                    
            $this->sections = CLUtil::getLabelForType ();
            asort ($this->sections);
                  
            $this->render ('homeChrome.php');
        }
        
        public function random ()
        {
            $this->q = $_GET['q'];
            $this->meta['h1'] = 'Craig\'s Little Buddy';
            $this->meta['h2'] = 'Say Something Randoms';           
            $this->meta['subLogoText'] = 'Random'; 
            $this->meta['title'] = 'Randomness - Craig\'s Little Buddy';            
            $this->render ();            
        }
        
        public function sitemap ()
        {
            $this->meta['h1'] = 'Craig\'s Little Buddy';
            $this->meta['h2'] = 'Wacha Lookin\' For?';           
            $this->meta['subLogoText'] = 'Site Map'; 
            $this->meta['title'] = 'Helping You Search Craigslist - Craig\'s Little Buddy';  
            $this->sections = CLUtil::getLabelForType ();
            asort ($this->sections);         
            $this->render ();                     
        }
        
        public function about ()
        {
            $this->meta['subLogoText'] = 'About';
            $this->meta['h1'] = 'Craig\'s Little Buddy';
            $this->meta['h2'] = 'About Us';
            $this->meta['title'] = 'About Us';
            $this->render ();
        }
        
        public function contact ()
        {
            $this->meta['subLogoText'] = 'Contact Us';
            $this->meta['h1'] = 'Craig\'s Little Buddy';
            $this->meta['h2'] = 'Wanna Get A Hold of The Little Buddy?';
            $this->meta['title'] = 'Contact Us';
            $this->render ();
        }

        public function faq ()
        {
            $this->meta['subLogoText'] = 'FAQ';
            $this->meta['h1'] = 'Craig\'s Little Buddy';
            $this->meta['h2'] = 'Frequently Asked Questions';
            $this->meta['title'] = 'FAQ';
            $this->render ();
        }   

        protected function setupVars ()
        {
            $this->searchOptions = new Stub;
            $this->searchOptions->cities = CLUtil::getUsedCities ();
        }
	}
?>
