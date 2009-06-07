<?php
    @ini_set('zend_monitor.enable', 0);
    if(@function_exists('output_cache_disable')) 
    {
        @output_cache_disable();
    }
    
    if (function_exists('debugger_connect'))  
    {
        debugger_connect();
        echo "<a href='/' target='_debug'>go</a>";
    } 
    else 
    {
        echo "No connector is installed.";
    }
?>
 