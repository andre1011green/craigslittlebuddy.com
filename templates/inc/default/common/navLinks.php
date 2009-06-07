<div id="nav">
    <div class="navLinks">
        <?
            $types = array_slice (CLUtil::getLabelForType (), 0, 11);
            
            if  ($searchType && ! array_search (CLUtil::getLabelForType ($searchType), $types))
            {
                //unset ($types['instruments']);
                $types[$searchType] = CLUtil::getLabelForType ($searchType); 
            }
            
            foreach ($types as $k => $v)
            {
                echo ($searchType != $k) ? "<a href=\"/$k\">$v</a>" :  "<span>$v</span>"; 
            } 
            
        ?>
        
        <a href="/home/sitemap">more &raquo;</a>
    </div>
    
    <!--
    <div class="userLinks">
        <a href="/" style="margin-left: 0px">Home</a>
        <a href="#">Sign Up</a>
        <a href="#">Login</a>                
    </div>
    -->
</div>