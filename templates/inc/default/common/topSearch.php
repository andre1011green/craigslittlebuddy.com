<?
    $action = (! empty ($searchType)) ? '/' . urlencode ($searchType) : '/search';
?>
<div id="mainSearch">
    <div class="layout">
        <div class="txt">
            <a href="/"><img src="/_/images/logo/mainText.gif" alt="Craig's Little Buddy" /></a>
            <strong><?= $meta['subLogoText'] ?></strong>
        </div>
        
        <div class="frm">
            <form action="<?= $action ?>" name="mainForm" method="GET" onsubmit="showLoading (); return true">
                <input class="txt" name="q" type="text" maxlength="255" value="<?= (empty ($q) ? '' : htmlentities ($q)) ?>" />
                <input type="submit" class="btn" value="Search"/>
                <? if (! empty ($sort)) : ?>
                    <input type="hidden" value="<?= htmlentities ($sort) ?>" name="sort" />
                <? endif; ?>
            </form>
            <p>
                searching <span id="customNumCities"><?= count ($searchOptions->cities) ?></span> craigslist cities 
                <a id="showCityDialogLink" href="javascript: void (null)">customize</a>
            </p>
        </div>
        
        <div class="options">
            <!--
            <a href="javascript: void (null);" onmouseover="showSavedSearches ()">saved searches &darr;</a>
            <a href="javascript: showAdvanced ()">advanced</a>
             -->
        </div>
        
        <script>document.forms['mainForm'].elements['q'].focus ();</script>
    </div>
</div>