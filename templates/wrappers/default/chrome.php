<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title><?= htmlentities ($meta['title']) ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="description" content="<?= htmlentities ($meta['description']) ?>" />
        <meta name="keywords" content="<?= htmlentities ($meta['keywords']) ?>" />
                
        <link type="text/css" rel="stylesheet" href="/_/css/style.css?v=1"></link>
        <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.5.1/build/container/assets/skins/sam/container.css"></link>
        <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.5.1/build/button/assets/skins/sam/button.css"></link>
        
        <link type="text/css" rel="stylesheet" href="/_/css/cityDialog.css" />
        <script type="text/javascript" src="/_/js/search.js"></script>
        <? $this->inc ('common/ieCss.php') ?>
    </head>
    
    <body class="yui-skin-sam">
        <div id="content">
            <? $this->inc ('common/navLinks.php'); ?>
            <br class="clear" />
            <? $this->inc ('common/topSearch.php'); ?>
            <? $this->inc ('common/h1h2.php') ?>
            
            <div id="main">
                <?= $__CONTENT__ ?>
            </div>
            
            <div id="loading">
                <p>
                    Kick back and relax. This will take a second.<br />
                </p>
                
                <p>
                    <img width="300" src='/_/images/loading-bar.gif' />
                </p>
            </div>
                        
            <?
                $this->inc ('common/footer.php');
                $this->inc ('search/cityDialog.php'); 
            ?>
        </div>
        
    </body>
</html> 