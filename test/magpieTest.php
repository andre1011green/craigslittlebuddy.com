<?
    ini_set ('include_path', '.');
    require ('../ext/magpieRss/rss_fetch.inc');
    
    $rssData = fetch_rss ('http://www.alittlered.com/crap/test.xml');
    //	print_r (array_keys ($rssData->items[0]));
    
    foreach ($rssData->items as $item)
    {
        $ts = strtotime ($item['dc']['date']);
    
        echo
        //				substr ($item['link'], 0),
        //				"\t",
        //				$item['clDomain'],
        //				"\t",
        substr ($item['dc']['title'], 0, 10),
        //				"\t",
        //				$item['dc']['unixtime'],
        //				"\t",
        //				date ('r', $ts),
    				"\n";
    }
    
    echo count ($rssData->items), " items\n";
?>