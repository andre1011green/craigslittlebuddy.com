<?
    $numPages = ceil ($totalResults / SearchAction::RESULTS_PER_PAGE); 
    $action = (! empty ($searchType)) ? '/' . urlencode ($searchType) : '/search';    
    
    function getPaginationUrl ($n, $q = null, $action = null, $sort = null, $page = null)
    {
        $parts = array ();
        
        if ($q) $parts[] = "q=" . urlencode ($q);
        if ($sort) $parts[] = "sort=$sort";
        if ($n != 1) $parts[] = "page=$n";
        
        $parts['s'] = "s=1";
        return "$action?" . implode ('&', $parts);
    }
?>

<div class="pagination">
    <? if (1 != $page) : ?>
        <a class="arrow" href="<?= getPaginationUrl ($page - 1, $q, $action, $sort, $page) ?>">&laquo;</a>
    <? endif; ?>
    
    <? for ($i = 0; $i < $numPages; $i++) : ?>
        <? $num = $i + 1; ?>
        <? if ($num != $page) : ?>
            <a href="<?= getPaginationUrl ($num, $q, $action, $sort, $page) ?>"><?= $num ?></a>
        <? else: ?>
            <span><?= $num ?></span>
        <? endif; ?>
    <? endfor; ?>
    
    <? if ($numPages != $page) : ?>
        <a class="arrow" href="<?= getPaginationUrl ($page + 1, $q, $action, $sort, $page) ?>">&raquo;</a>
    <? endif; ?>    
</div>