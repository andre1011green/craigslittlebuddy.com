<?
    $action = (! empty ($searchType)) ? '/' . urlencode ($searchType) : '/search';
?>

<div class="sortBar">
    <form action="<?= $searchType ?>" method="GET">
        <input type="hidden" name="q" value="<?= (empty ($q) ? '' : htmlentities ($q)) ?>" />
        Sorted by&nbsp;
        <select name="sort" onchange="showLoading (); this.form.submit ();">
            <? 
                foreach ($sortOptions as $k => $v)
                {
                    $sel = ($k == $sort) ? 'selected="true"' : '';
                    echo "<option value=\"{$k}\" $sel>{$v}</option>";
                }
            ?>
        </select>
    </form>
</div>