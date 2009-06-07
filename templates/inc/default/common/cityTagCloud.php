<?
    $action = (! empty ($searchType)) ? urlencode ($searchType) : 'search';
    $sortMe = $countByDomain;
    
    asort ($sortMe);
    $most = array_pop ($sortMe);
?>

<div class="tagCloud">
    <? 
        $min = 120;
        $baseUrl = "/search/goto?section={$action}&s=1&q=" .  urlencode ($q) . "&sort=" . SearchAction::SORT_CITY;
        
        foreach ($countByDomain as $k => $v) :
            if (! $v) continue;
            $size = ($v / $most * 210);
            $size = ceil (($size < $min) ? $min : $size); 
            $class = 'tc' . floor ($i++ %4);
            
            $url = $onClick = null;
            if ($citiesOnPage[$k])
            {
                $url = "#{$k}";
            }
            else
            {
                $url = "{$baseUrl}&city={$k}";
                $onClick = 'onclick="showLoading ();"';
            }
    ?>
        <a <?= $onClick ?> class="<?= $class ?>" style="font-size: <?= $size ?>%;" href="<?= $url ?>">
            <?= str_replace ('/', ' ', strtolower (CLUtil::getCityForClDomain ($k))) ?></a>
    <? endforeach; ?>
</div>

<pre>
    <? //print_r ($countByDomain) ?>
</pre>