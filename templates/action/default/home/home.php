<div class="homeBg">
    <div class="frm">
        <form action="/search" method="GET">
            <input class="txt" maxlength="255" name="q" type="text" value="<?= (empty ($q) ? '' : htmlentities ($q)) ?>" />
            <button class="homeSearch"></button>
        </form>    
    </div>
</div>

<div>
    <h2>What You Wanna Search For?</h2>
    
    <? $this->inc ('common/sitemapLinks.php') ?>
</div>

<script>
    document.forms[0].elements['q'].focus ();
</script>