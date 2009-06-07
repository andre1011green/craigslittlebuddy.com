        <? if (stristr ($_SERVER['HTTP_USER_AGENT'], 'msie')) : ?>
            <link type="text/css" rel="stylesheet" href="/_/css/ie.css" />
        <? endif; ?>
        
        <? if (stristr ($_SERVER['HTTP_USER_AGENT'], 'MSIE 6')) : ?>
            <style>
                DIV.homeBg DIV.frm {
                    margin-left: 145px;
                }            
            </style>
        <? endif; ?>        