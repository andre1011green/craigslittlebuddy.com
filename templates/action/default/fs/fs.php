<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>
            <?= htmlentities ($result['title']) ?> |
            <?= CLUtil::getCityForClDomain ($result['clb']['clDomain']) ?> (<?= $result['clb']['location'] ?>)
            <?= ($result['clb']['price']) ? ' | $' . $result['clb']['price'] : '' ?>
            
        </title>
        
        <link type="text/css" rel="stylesheet" href="/_/css/style.css" />
        <link type="text/css" rel="stylesheet" href="/_/css/fs.css" />
        <? $this->inc ('common/ieCss.php') ?>
    </head>
    
    <body>
        <div id="content" class="fs">
            <?
                $action = (! empty ($searchType)) ? '/' . urlencode ($searchType) : '/search';
                $url = $action . "?q=" . htmlentities ($searchOptions->q) . "&sort=" . htmlentities ($sort) . "&s=1"
            ?>
            
            <span class="bread">
                <a target="_parent" href="/">Craigs Little Buddy</a> &raquo;
                <? if ($searchType == 'search') : ?>
                    <a target="_parent" href="/search?sort=<?= $sort ?>&q=<?= urlencode ($searchOptions->q) ?>">Search</a> &raquo;
                <? else: ?>
                    <a target="_parent" href="/search?sort=<?= $sort ?>&q=<?= urlencode ($searchOptions->q) ?>">Search</a> &raquo;
                    <a target="_parent" href="/<?= $searchType ?>?sort=<?= $sort ?>&q=<?= urlencode ($searchOptions->q) ?>"><?= CLUtil::getLabelForType ($searchType) ?></a> &raquo;             
                <? endif; ?>
                
                <a target="_parent" href="<?= $result['link']?>">this ad</a>
            </span>              

            <div class="dude l">
                <a href="<?= $url ?>"><img src="/_/images/logo/littleDude.gif" /></a>
            </div>
            
            <div class="frm l">
                <a target="_parent" href="<?= $url ?>"><img alt="Craig's Little Buddy" src="/_/images/logo/mainText.gif"></a>
                <form action="<?= $action ?>" target="_parent">
                    <input type="text" name="q" class="txt" value="<?= htmlentities ($searchOptions->q) ?>" />
                    <input type="submit" class="btn" value="Search"/>
                    <? if (! empty ($sort)) : ?>
                        <input type="hidden" value="<?= htmlentities ($sort) ?>" name="sort" />
                    <? endif; ?>                    
                </form>
            </div>
            
            <div class="resInfo" align="right">
                <p>
                    Result <b><?= number_format ($i + 1); ?> of <?= number_format ($totalResults); ?></b>                
                </p>

                <? if ($i != 0) : ?>
                    <a target="_parent" href="<?= '/browseResults?q='
                                        . urlencode ($searchOptions->q)
                                        . "&sort={$sort}"
                                        . "&type={$searchType}"
                                        . "&p=" . urlencode ($prevResult['link']); ?>">
                                        <img src="/_/images/buttons/prev.gif" /></a>
                <? endif; ?>
                
                <? if ($i != ($totalResults - 1)) : ?>
                    <a target="_parent" href="<?= '/browseResults?q='
                                        . urlencode ($searchOptions->q)
                                        . "&sort={$sort}"
                                        . "&type={$searchType}"
                                        . "&p=" . urlencode ($nextResult['link']); ?>">
                                        <img src="/_/images/buttons/next.gif" /></a>
                <? endif; ?> 
            </div>
            <br class="clear"/>
        </div>
        
        <? $this->inc ('common/ga.php'); ?>
        
        <div class="sm">
            <!-- Site Meter -->
            <script type="text/javascript" src="http://s48.sitemeter.com/js/counter.js?site=s48craigslittlebuddy">
            </script>
            <noscript>
            <a href="http://s48.sitemeter.com/stats.asp?site=s48craigslittlebuddy" target="_top">
            <img src="http://s48.sitemeter.com/meter.asp?site=s48craigslittlebuddy" alt="Site Meter" border="0"/></a>
            </noscript>
        </div>
        <!-- Copyright (c)2006 Site Meter -->
        <? $this->inc ('common/ga.php'); ?>
    </body>
</html>