<div class="sitemap">
    <? 
        $links = array ();
        foreach ($sections as $type => $label)
        {
            if ($type == 'search') continue;
            $i++;
               
            $links[] = "<span><a href=\"/{$type}\">{$label}</a></span>";
            
            if (count ($links) == 6)
            {
                echo '<div>', implode ('<br />', $links), '</div>', "\n";
                $links = array ();
            }
        }
    ?>
</div>
<br class="clear" />