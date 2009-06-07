<?
    $baseUrl = "http://chicago.craigslist.org/search/msg?query=&maxAsk=max&format=rss&minAsk=";
    $priceList = array ();
    for ($i = 0; $i < 280; $i++) $priceList[] = $i;
    $pids = array ();
    
    $start = microtime (true);
    foreach ($priceList as $price)
    {
    	echo "$price\n";
        $str = file_get_contents ($baseUrl . $price);
    }    
    
    $end = microtime (true);    
    $time = $end - $start;
    echo "PARALLEL ($time)\n";    
?>