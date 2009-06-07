<div class="col1">
    <? if ($errorCode) : ?>
        <div class="searchError">
            <?= ErrorUtil::getError ($errorCode); ?>
        </div>
    <? endif; ?>

    <?
        $this->inc ('common/paginationInfo.php'); 
        $lastDomain = null;
        $maxTitleChars = 45;
        $citiesOnPage = array ();
        $i = 0;
        $linkInfo = array ();
        
        foreach ($searchResults as $result) :
            $linkInfo[] = $result['link'];
            //echo "LAST DOMAIN: $lastDomain\n({$result['clb']['clDomain']})\n";
    ?>
        
        <? if (($sort == SearchAction::SORT_CITY) && ($lastDomain != $result['clb']['clDomain'])) : ?>
            <a name="<?= $result['clb']['clDomain'] ?>"></a>
            <? 
                $lastDomain = $result['clb']['clDomain']; 
                $citiesOnPage[$lastDomain] = true;
                echo '<h3>', CLUtil::getCityForClDomain ($lastDomain), '</h3>';
            ?>
        <? endif; ?>
        
        <div class="result">
            <div class="heading">
                <? 
                    $title = trim ($result['title']);
                    if (strlen ($title) > $maxTitleChars) $title = (substr ($title, 0, $maxTitleChars) . '...');
                    $title = $title; //htmlentities ($title); 
                    
                    $link = "/browseResults/?q=" .  
                                urlencode ($q) .
                                "&type={$searchType}&sort={$sort}" . 
                                "&p=" . urlencode ($result['link']);
//                                "&i=" . (($page -1) * SearchAction::RESULTS_PER_PAGE + $i++)                                
                ?>
                <a title="<?= $title ?>" href="<?= $link ?>"><strong><?= $title ?></strong></a>
                <? if (! empty ($result['clb']['price'])) : ?>
                    <a class="money" title="<?= $title ?>" href="<?= $result['link'] ?>"><strong>$<?= number_format ($result['clb']['price']); ?></strong></a>
                <? endif; ?>
            </div>
            
            <div class="details">
                <b>Listed</b> (<?= date ('M j, g:ia T', $result['clb']['unixtime']) ?>)<br />
                
                <b><?= CLUtil::getCityForClDomain ($result['clb']['clDomain']) ?></b>
                <? if ($result['clb']['location']) : ?>
                    <?= $result['clb']['location'] ?>
                <? endif; ?>
                <br />
                
                <? if ($searchType == 'search') : ?>
                    <? $cat = CLUtil::getCategoryFromUrl ($result['link']); ?>
                    <b>Category:</b> 
                    <a href="/<?= $cat?>?q=<?= urlencode ($searchOptions->q) ?>&sort=<?= urlencode ($sort) ?>">
                        <?= CLUtil::getLabelForType ($cat) ?></a>
                <? endif; ?>
            </div>
            
            <? if (! empty ($result['description'])) : ?>
                <div class="description" id="desc_<?= $i++ ?>">
                    <? if (! empty ($result['clb']['images'])) : ?>
                        <div class="thumb" id="thumb_<?= $i ?>">
                            <a href="<?= $link ?>" title="<?= $title ?>">
                                <img alt="<?= $title ?>" src="<?= $result['clb']['images'][0] ?>" /></a></div>
                    <? endif; ?>
                    <?= $result['clb']['displayText']; ?> ...
                </div>
            <? endif; ?>
        <br class="clear" />
        </div>
    <? endforeach; ?>
    
    <? $this->inc ('common/searchPagination.php'); ?> 
</div>

<div class="col2 center">   
    <!--    
    <div class="resultsFoundIn">
        <img src="/_/images/txt/resultsFoundIn.gif" alt="results found in the following craigslist sites" />
    </div> 
    -->
        
    <?
        $this->assign ('citiesOnPage', $citiesOnPage); 
        $this->inc ('common/cityTagCloud.php'); 
        if ($_GET['ip']) $this->inc ('common/imagePreviewSwf.php');
    ?>
</div>

<br class="clear" />
