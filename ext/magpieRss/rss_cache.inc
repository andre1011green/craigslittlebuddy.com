<?php
/*
 * Project:     MagpieRSS: a simple RSS integration tool
 * File:        rss_cache.inc, a simple, rolling(no GC), cache 
 *              for RSS objects, keyed on URL.
 * Author:      Kellan Elliott-McCrea <kellan@protest.net>
 * Version:     0.51
 * License:     GPL
 *
 * The lastest version of MagpieRSS can be obtained from:
 * http://magpierss.sourceforge.net
 *
 * For questions, help, comments, discussion, etc., please join the
 * Magpie mailing list:
 * http://lists.sourceforge.net/lists/listinfo/magpierss-general
 *
 */

class RSSCache {
    var $BASE_CACHE = './cache';    // where the cache files are stored
    var $MAX_AGE    = 3600;         // when are files stale, default one hour
    var $ERROR      = "";           // accumulate error messages
    
    function RSSCache ($base='', $age='') {
        if ( $base ) {
            $this->BASE_CACHE = $base;
        }
        if ( $age ) {
            $this->MAX_AGE = $age;
        }
        
        // attempt to make the cache directory
        if ( ! file_exists( $this->BASE_CACHE ) ) {
            $status = @mkdir( $this->BASE_CACHE, 0755 );
            
            // if make failed 
            if ( ! $status ) {
                $this->error(
                    "Cache couldn't make dir '" . $this->BASE_CACHE . "'."
                );
            }
        }
    }
    
/*=======================================================================*\
    Function:   set
    Purpose:    add an item to the cache, keyed on url
    Input:      url from wich the rss file was fetched
    Output:     true on sucess  
\*=======================================================================*/
    function set ($url, $rss, $cache_status = false) {
    	$append = (CLB_RSS_MERGE && $cache_status && $cache_status == 'STALE');
        $this->ERROR = "";
        $cache_file = $this->file_name( $url );
        
        
        $this->fixData ($rss, $url);
        if ($append) $this->merge ($cache_file, $rss);        	

    	$fp = fopen( $cache_file, 'w');
        
        if ( ! $fp ) {
            $this->error(
                "Cache unable to open file for writing: $cache_file"
            );
            return 0;
        }
        
        $data = $this->serialize( $rss );
        fwrite( $fp, $data );
        fclose( $fp );
        
        return $cache_file;
    }
    
    function d ($s)
    {
    	echo print_r ($s, 1), "\n";
    }
    
    function fixData (&$rss, $url)
    {
    	$num = count ($rss->items);
    	$matches = array ();
    	preg_match ('/http:\/\/(.+)\.craigslist\.org/', $url, $matches);
    echo "<!-- HEYHEY\n";
    print_r($matches);
    echo '-->';
    	
    	for ($i = 0; $i < $num; $i++)
    	{
    	    $rss->items[$i]['clb'] = array ();
    		$rss->items[$i]['clb']['clDomain'] = $matches[1];	
            $rss->items[$i]['clb']['displayText'] = substr (strip_tags ($rss->items[$i]['description']), 0, 300);       		
    		$rss->items[$i]['clb']['unixtime'] = strtotime ($rss->items[$i]['dc']['date']);
    		$rss->items[$i]['clb']['link'] = "/browse/" . urlencode ($rss->items[$i]['link']);
    	    
    	    if (preg_match ('/^(.*)\$(.*)$/', $rss->items[$i]['title'], $titleMatches))
    	    {
                $rss->items[$i]['title'] = trim ($titleMatches[1]);
                $rss->items[$i]['clb']['price'] = trim ($titleMatches[2]);
    	    }
    	    
    	    if (preg_match ('/^(.*)\(+(.*)\)+$/', $rss->items[$i]['title'], $locMatches))
    	    {
    	        $rss->items[$i]['title'] = trim ($locMatches[1]);
    	        $rss->items[$i]['clb']['location'] = $locMatches[2];
    	    }
    	    
    	    if (preg_match ('/<img src\="(.*?jpg|jpeg|gif|bmp|png)"/i', $rss->items[$i]['description'], $imgMatches))
    	    {
                array_shift ($imgMatches);
    	        $rss->items[$i]['clb']['images'] = array ();
    	        
                foreach ($imgMatches as $src)
                {
                   if (stripos ($src, 'http') === 0) 
                   {
                       $rss->items[$i]['clb']['images'][] = strip_tags ($src);
                       break;
                   }
                }    	        
    	    }
                	    
    	}
    }
    
    function merge ($cache_file, &$rss)
    {
    	$maxItemAge = strtotime ('2 weeks ago'); 
    	$modTime = filemtime ($cache_file);
    	
    	// no mod time or the modTime is older than the maxItemAge
    	if (! $modTime || $modTime < $maxItemAge) return;
    	
    	$old = unserialize (file_get_contents ($cache_file));    	
    	$numNewItems = count ($rss->items);
    	$ready = false;
    	
    	if ($numNewItems)
    	{
        	$lastIndex = $numNewItems - 1;
        	$readyLink = $rss->items[$lastIndex]['link']; 			 	// last link from new set
        	$readyTime = $rss->items[$lastIndex]['dc']['unixtime']; 	// oldest timestamp from new set
    	}
    	else
    	{
    	    // if there's nothing in the new RSS just start pruning the old data
            $ready = true;        	    
    	}
			
    	if ($old && ! empty ($old->items))
    	{
    		while ($item = array_shift ($old->items))
    		{    			
    		    $linkMatch = ($item['link'] == $readyLink);
    		    
    			if (! $ready && 
    					($linkMatch || $item['dc']['unixtime'] < $readyTime))
    			{
    				$ready = true;
    			}
    			
    			if ($ready && ! $linkMatch)
    			{
	    			if ($item['dc']['unixtime'] > $maxItemAge)
					{
	    				$rss->items[] = $item;
					}
    			}
    		}
    	} 
    }
    
/*=======================================================================*\
    Function:   get
    Purpose:    fetch an item from the cache
    Input:      url from wich the rss file was fetched
    Output:     cached object on HIT, false on MISS 
\*=======================================================================*/ 
    function get ($url) {
        $this->ERROR = "";
        $cache_file = $this->file_name( $url );
        
        if ( ! file_exists( $cache_file ) ) {
            $this->debug( 
                "Cache doesn't contain: $url (cache file: $cache_file)"
            );
            return 0;
        }
        
        $fp = @fopen($cache_file, 'r');
        if ( ! $fp ) {
            $this->error(
                "Failed to open cache file for reading: $cache_file"
            );
            return 0;
        }
        
        if ($filesize = filesize($cache_file) ) {
        	$data = fread( $fp, filesize($cache_file) );
        	$rss = $this->unserialize( $data );
        
        	return $rss;
    	}
    	
    	return 0;
    }

/*=======================================================================*\
    Function:   check_cache
    Purpose:    check a url for membership in the cache
                and whether the object is older then MAX_AGE (ie. STALE)
    Input:      url from wich the rss file was fetched
    Output:     cached object on HIT, false on MISS 
\*=======================================================================*/     
    function check_cache ( $url ) {
        $this->ERROR = "";
        $filename = $this->file_name( $url );
        
        if ( file_exists( $filename ) ) {
            // find how long ago the file was added to the cache
            // and whether that is longer then MAX_AGE
            $mtime = filemtime( $filename );
            $age = time() - $mtime;
            if ( $this->MAX_AGE > $age ) {
                // object exists and is current
                return 'HIT';
            }
            else {
                // object exists but is old
                return 'STALE';
            }
        }
        else {
            // object does not exist
            return 'MISS';
        }
    }

	function cache_age( $url ) {
		$filename = $this->file_name( $url );
		if ( file_exists( $filename ) ) {
			$mtime = filemtime( $filename );
            $age = time() - $mtime;
			return $age;
		}
		else {
			return -1;	
		}
	}
	
/*=======================================================================*\
    Function:   serialize
\*=======================================================================*/     
    function serialize ( $rss ) {
        return serialize( $rss );
    }

/*=======================================================================*\
    Function:   unserialize
\*=======================================================================*/     
    function unserialize ( $data ) {
        return unserialize( $data );
    }
    
/*=======================================================================*\
    Function:   file_name
    Purpose:    map url to location in cache
    Input:      url from wich the rss file was fetched
    Output:     a file name
\*=======================================================================*/     
    function file_name ($url) {
        $filename = md5( $url );
        return join( DIRECTORY_SEPARATOR, array( $this->BASE_CACHE, $filename ) );
    }

/*=======================================================================*\
    Function:   error
    Purpose:    register error
\*=======================================================================*/         
    function error ($errormsg, $lvl=E_USER_WARNING) {
        // append PHP's error message if track_errors enabled
        if ( isset($php_errormsg) ) { 
            $errormsg .= " ($php_errormsg)";
        }
        $this->ERROR = $errormsg;
        if ( MAGPIE_DEBUG ) {
            trigger_error( $errormsg, $lvl);
        }
        else {
            error_log( $errormsg, 0);
        }
    }
    
    function debug ($debugmsg, $lvl=E_USER_NOTICE) {
        if ( MAGPIE_DEBUG ) {
            $this->error("MagpieRSS [debug] $debugmsg", $lvl);
        }
    }

}

?>
