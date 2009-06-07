<?
	class CLUtil
	{
	    const DEFAULT_TYPE = 'all';
	    const DEFAULT_Q = '*';
	    
	    public static function getSearchOptions ($type = 'all', $q = '*', $page = 1, $cities = array ())
	    {
	        if (empty ($cities))
	        {
	            $cities = array_keys (self::getDefaultCities ());
	        }
	        
	        return new ClSearchOptions ($q, $type, $page, $cities);
	    }
	    
	    public static function cookieDomains ($domains)
	    {
           $val = implode (',', $domains);
           CookieUtil::put (CookieUtil::KEY_CITIES, $val, time() + 60 * 60 * 24 * 365);	        
	    }
	    
	    public static function getCategoryFromUrl ($url)
	    {
	        $str = implode ('|', self::getTypeTranslations ());
	        $regex = "/\/($str)\//";
	        
	        if (preg_match ($regex, $url, $matches))
	        {
	            $clType = $matches[1];
	            $trans = self::getTypeTranslations ();
	            $k = array_search ($clType, $trans);
	            return $k;
	        }
	    }
	    
	    public static function getCLType ($myType)
	    {
	        $types = self::getTypeTranslations ();
	        return $types[strtolower ($myType)]; 
	    }
	    
	    public static function getClUrlForDomain ($domain, $section = null)
	    {
	        return "http://{$domain}.craigslist.org/{$section}";
	    }
	    
	    public static function getUsedCities ()
	    {
	        $cookieVal = CookieUtil::get (CookieUtil::KEY_CITIES);
            $rtn = array ();
	        
	        if (empty ($cookieVal))
	        {
                $rtn = self::getDefaultCities ();
	        }
	        else
	        {
                $domains = explode (',', $cookieVal);
                
                foreach ($domains as $d)
                {
                    $rtn[$d] = self::getCityForClDomain ($d);
                }
                
	        }
	        
            asort ($rtn);
	        return array_keys ($rtn);
	    }
	    
	    public static function getTypeTranslations ()
	    {
	        return array (
	               'search' => 'sss',
	               'instruments' => 'msg',
	               'boats' => 'boa',
	               'wtb' => 'wan',
	               'auto-parts' => 'pts',
	               'cars' => 'cta',
                   'cars-by-owner' => 'cto',
	               'clothes' => 'clo',
	               'tickets' => 'tix',
	               'electronics' => 'ele',
	               'cd-dvd' => 'emd',
	               'books' => 'bks',
        	        'barter' => 'bar',
        	        'bikes' => 'bik',
        	        'business' => 'bfs',
        	        'computers' => 'sys',
        	        'free' => 'zip',
        	        'jewelry' => 'jwl',
        	        'material' => 'mat',
        	        'rvs' => 'rvs',
        	        'sporting-goods' => 'spo',
        	        'tools' => 'tls',
        	        'arts-crafts' => 'art',
        	        'baby-kids' => 'bab',
        	        'collectibles' => 'clt',
        	        'farm-garden' => 'grd',
        	        'furniture' => 'fua',
        	        'toys-games' => 'tag',
        	        'garage-sale' => 'gms',
        	        'household' => 'hsh',
	                'general' => 'for',
        	        'motorcycles' => 'mcy',
        	        'photo-video' => 'pho');
	    }
	    
	    public static function getLabelForType ($myType = null)
	    {
	        $myType = strtolower ($myType);
            
	        $a = array (
	               'search' => 'All',
                   'instruments' => 'Musical Instruments',
                   'boats' => 'Boats',
                   'wtb' => 'WTB',
	               'tickets' => 'Tickets',
                   'auto-parts' => 'Auto Parts',
                   'cars' => 'Cars/Trucks',
                   'clothes' => 'Clothes',
                   'electronics' => 'Electronics',
                   'cd-dvd' => 'CD/DVD',
                   'books' => 'Books',
            'barter' => 'Barter',
            'bikes' => 'Bikes',
            'business' => 'Business',
            'computers' => 'Computers',
            'free' => 'Free Stuff',
            'jewelry' => 'Jewelry',
            'material' => 'Material',
            'rvs' => 'RV',
            'sporting-goods' => 'Sporting Goods',
            'tools' => 'Tools',
            'arts-crafts' => 'Arts/Crafts',
            'baby-kids' => 'Baby/Kids',
            'collectibles' => 'Collectibles',
            'farm-garden' => 'Farm/Garden',
            'furniture' => 'Furniture',
            'toys-games' => 'Toys/Games',
            'garage-sale' => 'Garage Sale',
	        'general' => 'General For Sale',
            'household' => 'Household',
            'motorcycles' => 'Motorcycles',
            'cars-by-owner' => 'Cars by Owner', 
            'photo-video' => 'Photo/Video');

	        return ($myType) ? $a[$myType] : $a;
	    }
	    
	    public static function getDefaultCities ()
	    {
	        return array (
                'atlanta' => 'Atlanta',
                'austin' => 'Austin',
                'boston' => 'Boston',
                'chicago' => 'Chicago',
                'denver' => 'Denver',
                'houston' => 'Houston',
                'lasvegas' => 'Las Vegas',
                'losangeles' => 'Los Angeles',
                'miami' => 'Miami',
                'minneapolis' => 'Minneapolis',
                'newyork' => 'New York',
                'orangecounty' => 'Orange County',
                'philadelphia' => 'Philadelphia',
                'phoenix' => 'Phoenix',
                'portland' => 'Portland',
                'raleigh' => 'Raleigh',
                'sacramento' => 'Sacramento',
                'sandiego' => 'San Diego',
                'sfbay' => 'San Francisco',
                'seattle' => 'Seattle',
                'washingtondc' => 'Washington DC');
	    }
	    
	    public static function getAllCities ()
	    {
//	        return array (
//                'abilene' => 'Abilene',
//                'akroncanton' => 'Akron/Canton',
//                'anchorage' => 'Alaska',
//                'albany' => 'Albany',
//                'albuquerque' => 'Albuquerque',
//                'altoona' => 'Altoona/Johnstown',
//                'amarillo' => 'Amarillo',
//                'ames' => 'Ames, IA',
//                'annarbor' => 'Ann Arbor',
//                'appleton' => 'Appleton/OshkoshFDL',
//                'asheville' => 'Asheville',
//                'athensga' => 'Athens, GA',
//                'athensohio' => 'Athens, OH',
//                'atlanta' => 'Atlanta',	        
//	        );
	        
            return array (
                'abilene' => 'Abilene',
                'akroncanton' => 'Akron/Canton',
                'anchorage' => 'Alaska',
                'albany' => 'Albany',
                'albuquerque' => 'Albuquerque',
                'altoona' => 'Altoona/Johnstown',
                'amarillo' => 'Amarillo',
                'ames' => 'Ames, IA',
                'annarbor' => 'Ann Arbor',
                'appleton' => 'Appleton/OshkoshFDL',
                'asheville' => 'Asheville',
                'athensga' => 'Athens, GA',
                'athensohio' => 'Athens, OH',
                'atlanta' => 'Atlanta',
                'auburn' => 'Auburn',
                'augusta' => 'Augusta',
                'austin' => 'Austin',
                'bakersfield' => 'Bakersfield',
                'baltimore' => 'Baltimore',
                'batonrouge' => 'Baton Rouge',
                'beaumont' => 'Beaumont/Port Arthur',
                'bellingham' => 'Bellingham',
                'bend' => 'Bend',
                'binghamton' => 'Binghamton',
                'bham' => 'Birmingham, AL',
                'blacksburg' => 'Blacksburg',
                'bloomington' => 'Bloomington',
                'bn' => 'Bloomington-Normal',
                'boise' => 'Boise',
                'boone' => 'Boone',
                'boston' => 'Boston',
                'boulder' => 'Boulder',
                'bgky' => 'Bowling Green',
                'brownsville' => 'Brownsville',
                'buffalo' => 'Buffalo',
                'capecod' => 'Cape Cod/Islands',
                'carbondale' => 'Carbondale',
                'catskills' => 'Catskills',
                'cedarrapids' => 'Cedar Rapids',
                'cnj' => 'Central NJ',
                'centralmich' => 'Central Michigan',
                'chambana' => 'Champaign Urbana',
                'charleston' => 'Charleston, SC',
                'charlestonwv' => 'Charleston, WV',
                'charlotte' => 'Charlotte',
                'charlottesville' => 'Charlottesville',
                'chattanooga' => 'Chattanooga',
                'chautauqua' => 'Chautauqua',
                'chicago' => 'Chicago',
                'chico' => 'Chico',
                'cincinnati' => 'Cincinnati, OH',
                'cleveland' => 'Cleveland',
                'collegestation' => 'College Station',
                'cosprings' => 'Colorado Springs',
                'columbiamo' => 'Columbia/Jeff City',
                'columbia' => 'Columbia, SC',
                'columbus' => 'Columbus',
                'columbusga' => 'Columbus, GA',
                'corpuschristi' => 'Corpus Christi',
                'corvallis' => 'Corvallis',
                'dallas' => 'Dallas/Fort Worth',
                'danville' => 'Danville',
                'dayton' => 'Dayton/Springfield',
                'daytona' => 'Daytona Beach',
                'delaware' => 'Delaware',
                'denver' => 'Denver',
                'desmoines' => 'Des Moines',
                'detroit' => 'Detroit Metro',
                'dubuque' => 'Dubuque',
                'duluth' => 'Duluth/Superior',
                'eastidaho' => 'East Idaho',
                'eastoregon' => 'East Oregon',
                'newlondon' => 'Eastern CT',
                'eastnc' => 'Eastern NC',
                'easternshore' => 'Eastern Shore',
                'eauclaire' => 'Eau Claire',
                'elpaso' => 'El Paso',
                'elmira' => 'Elmira-corning',
                'erie' => 'Erie, PA',
                'eugene' => 'Eugene',
                'evansville' => 'Evansville',
                'fargo' => 'Fargo/Moorhead',
                'fayetteville' => 'Fayetteville',
                'fayar' => 'Fayetteville, AR',
                'flagstaff' => 'Flagstaff/Sedona',
                'flint' => 'Flint',
                'keys' => 'Florida Keys',
                'fortcollins' => 'Fort Collins/North CO',
                'fortlauderdale' => 'Fort Lauderdale',
                'fortsmith' => 'Fort Smith, AR',
                'fortwayne' => 'Fort Wayne',
                'fresno' => 'Fresno',
                'fortmyers' => 'Ft Myers/SW Florida',
                'gainesville' => 'Gainesville',
                'goldcountry' => 'Gold Country',
                'grandisland' => 'Grand Island',
                'grandrapids' => 'Grand Rapids',
                'greenbay' => 'Green Bay',
                'greensboro' => 'Greensboro',
                'greenville' => 'Greenville/Upstate',
                'gulfport' => 'Gulfport/Biloxi',
                'norfolk' => 'Hampton Roads',
                'harrisburg' => 'Harrisburg',
                'harrisonburg' => 'Harrisonburg',
                'hartford' => 'Hartford',
                'hattiesburg' => 'Hattiesburg',
                'honolulu' => 'Hawaii',
                'hiltonhead' => 'Hilton Head',
                'houston' => 'Houston',
                'hudsonvalley' => 'Hudson Valley',
                'humboldt' => 'Humboldt County',
                'huntington' => 'Huntington-Ashland',
                'huntsville' => 'Huntsville',
                'indianapolis' => 'Indianapolis',
                'inlandempire' => 'Inland Empire/Riverside/San B',
                'iowacity' => 'Iowa City',
                'ithaca' => 'Ithaca',
                'jxn' => 'Jackson, MI',
                'jackson' => 'Jackson, MS',
                'jacksonville' => 'Jacksonville',
                'jonesboro' => 'Jonesboro',
                'joplin' => 'Joplin',
                'kalamazoo' => 'Kalamazoo',
                'kansascity' => 'Kansas City, MO',
                'kpr' => 'Kennewick/Pasco/Richland',
                'killeen' => 'Killeen/Temple/Ft Hood',
                'knoxville' => 'Knoxville',
                'lacrosse' => 'La Crosse',
                'lafayette' => 'Lafayette',
                'tippecanoe' => 'Lafayette/West Lafayette',
                'lakecharles' => 'Lake Charles',
                'lakeland' => 'Lakeland',
                'lancaster' => 'Lancaster, PA',
                'lansing' => 'Lansing',
                'laredo' => 'Laredo',
                'lascruces' => 'Las Cruces',
                'lasvegas' => 'Las Vegas',
                'lawrence' => 'Lawrence',
                'lawton' => 'Lawton',
                'allentown' => 'Lehigh Valley',
                'lexington' => 'Lexington, KY',
                'limaohio' => 'Lima/Findlay',
                'lincoln' => 'Lincoln',
                'littlerock' => 'Little Rock',
                'logan' => 'Logan',
                'longisland' => 'Long Island',
                'losangeles' => 'Los Angeles',
                'louisville' => 'Louisville',
                'lubbock' => 'Lubbock',
                'lynchburg' => 'Lynchburg',
                'macon' => 'Macon',
                'madison' => 'Madison',
                'maine' => 'Maine',
                'ksu' => 'Manhattan, KS',
                'mankato' => 'Mankato',
                'mansfield' => 'Mansfield',
                'martinsburg' => 'Martinsburg',
                'mcallen' => 'Mcallen/Edinburg',
                'medford' => 'Medford/Ashland/Klamath',
                'memphis' => 'Memphis, TN',
                'merced' => 'Merced',
                'miami' => 'Miami',
                'milwaukee' => 'Milwaukee',
                'minneapolis' => 'Minneapolis/St Paul',
                'mobile' => 'Mobile',
                'modesto' => 'Modesto',
                'montana' => 'Montana',
                'monterey' => 'Monterey Bay',
                'montgomery' => 'Montgomery',
                'morgantown' => 'Morgantown',
                'muncie' => 'Muncie/Anderson',
                'myrtlebeach' => 'Myrtle Beach',
                'nashville' => 'Nashville',
                'nh' => 'New Hampshire',
                'newhaven' => 'New Haven',
                'neworleans' => 'New Orleans',
                'newyork' => 'New York City',
                'nd' => 'North Dakota',
                'newjersey' => 'North Jersey',
                'northmiss' => 'North Mississippi',
                'nmi' => 'Northern Michigan',
                'nwct' => 'Northwest CT',
                'ocala' => 'Ocala',
                'odessa' => 'Odessa/Midland',
                'ogden' => 'Ogden-Clearfield',
                'oklahomacity' => 'Oklahoma City',
                'omaha' => 'Omaha/Council Bluffs',
                'orangecounty' => 'Orange County',
                'oregoncoast' => 'Oregon Coast',
                'orlando' => 'Orlando',
                'outerbanks' => 'Outer Banks',
                'palmsprings' => 'Palm Springs, CA',
                'parkersburg' => 'Parkersburg/Marietta',
                'pensacola' => 'Pensacola/Panhandle',
                'peoria' => 'Peoria',
                'philadelphia' => 'Philadelphia',
                'phoenix' => 'Phoenix',
                'pittsburgh' => 'Pittsburgh',
                'plattsburgh' => 'Plattsburgh/Adirondacks',
                'poconos' => 'Poconos',
                'portland' => 'Portland, OR',
                'prescott' => 'Prescott',
                'provo' => 'Provo/Orem',
                'pueblo' => 'Pueblo',
                'pullman' => 'Pullman/Moscow',
                'quadcities' => 'Quad Cities, IA/IL',
                'raleigh' => 'Raleigh/Durham/CH',
                'redding' => 'Redding',
                'reno' => 'Reno/Tahoe',
                'providence' => 'Rhode Island',
                'richmond' => 'Richmond',
                'roanoke' => 'Roanoke',
                'rmn' => 'Rochester, MN',
                'rochester' => 'Rochester, NY',
                'rockford' => 'Rockford',
                'rockies' => 'Rocky Mountains',
                'roswell' => 'Roswell/Carlsbad',
                'sacramento' => 'Sacramento',
                'saginaw' => 'Saginaw/Midland/Baycity',
                'salem' => 'Salem, OR',
                'saltlakecity' => 'Salt Lake City',
                'sanantonio' => 'San Antonio',
                'sandiego' => 'San Diego',
                'sfbay' => 'San Francisco Bay Area',
                'slo' => 'San Luis Obispo',
                'sanmarcos' => 'San Marcos',
                'santabarbara' => 'Santa Barbara',
                'santafe' => 'Santa Fe/Taos',
                'sarasota' => 'Sarasota/Bradenton',
                'savannah' => 'Savannah',
                'scranton' => 'Scranton/Wilkes-barre',
                'seattle' => 'Seattle-Tacoma',
                'shreveport' => 'Shreveport',
                'siouxcity' => 'Sioux City, IA',
                'southbend' => 'South Bend/Michiana',
                'southcoast' => 'South Coast',
                'sd' => 'South Dakota',
                'southjersey' => 'South Jersey',
                'spacecoast' => 'Space Coast',
                'spokane' => 'Spokane/Coeur D\'alene',
                'springfieldil' => 'Springfield, IL',
                'springfield' => 'Springfield, MO',
                'stcloud' => 'St Cloud',
                'stgeorge' => 'St George',
                'stlouis' => 'St Louis, MO',
                'pennstate' => 'State College',
                'stillwater' => 'Stillwater',
                'stockton' => 'Stockton',
                'syracuse' => 'Syracuse',
                'tallahassee' => 'Tallahassee',
                'tampa' => 'Tampa Bay Area',
                'terrahaute' => 'Terre Haute',
                'texarkana' => 'Texarkana',
                'toledo' => 'Toledo',
                'topeka' => 'Topeka',
                'treasure' => 'Treasure Coast',
                'tricities' => 'Tri-Cities TN',
                'tucson' => 'Tucson',
                'tulsa' => 'Tulsa',
                'tuscaloosa' => 'Tuscaloosa',
                'easttexas' => 'Tyler/East TX',
                'up' => 'Upper Peninsula',
                'utica' => 'Utica',
                'valdosta' => 'Valdosta',
                'ventura' => 'Ventura County',
                'burlington' => 'Vermont',
                'visalia' => 'Visalia/Tulare',
                'waco' => 'Waco',
                'washingtondc' => 'Washington, DC',
                'watertown' => 'Watertown',
                'wenatchee' => 'Wenatchee',
                'westpalmbeach' => 'West Palm Beach',
                'wv' => 'West Virginia (old)',
                'westky' => 'Western KY',
                'westmd' => 'Western Maryland',
                'westernmass' => 'Western Massachusetts',
                'westslope' => 'Western Slope',
                'wheeling' => 'Wheeling, WV',
                'wichita' => 'Wichita',
                'wichitafalls' => 'Wichita Falls',
                'wilmington' => 'Wilmington, NC',
                'winstonsalem' => 'Winston/Salem',
                'worcester' => 'Worcester/Central MA',
                'wyoming' => 'Wyoming',
                'yakima' => 'Yakima',
                'york' => 'York, PA',
                'youngstown' => 'Youngstown',
                'yuma' => 'Yuma');	        
	    }
	    
	    public static function getCityForClDomain ($domain)
	    {
	        $array = self::getAllCities ();
	        return $array[$domain];
	    }
	    
		public static function getDomains ()
		{
			
		}
		
		public static function getDomain ($domain)
		{
			
		}
		
		public static function getMainDomains ()
		{
			
		}
	}
?>
