<?
    $baseUrl = "http://chicago.craigslist.org/search/msg?query=&maxAsk=max&format=rss&minAsk=";
    $priceList = array ();
    for ($i = 0; $i < 280; $i++) $priceList[] = $i;
    $pids = array ();
    
    $start = microtime (true);
    foreach ($priceList as $price)
    {
        $pids[$price] = pcntl_fork ();
//        echo "start: $price {$pids[$price]}\n";
    
        if ($pids[$price])
        {
//            echo "parent\n";
        }
        elseif (! $pids[$price]) 
        {
            $str = file_get_contents ($baseUrl . $price);
//            echo "done: $price {$baseUrl}{$price}\n";
            exit ();
        }        
    }    
    
    foreach ($priceList as $price)
    {
        pcntl_waitpid ($pids[$price], $status, WUNTRACED);        
    }
    
    $end = microtime (true);    
    $time = $end - $start;
    echo "PARALLEL ($time)\n";    
    
//    echo shm_get_var ($res, 1);
?>