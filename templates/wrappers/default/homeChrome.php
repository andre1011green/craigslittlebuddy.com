<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title><?= htmlentities ($meta['title']) ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="description" content="<?= htmlentities ($meta['description']) ?>" />
        <meta name="keywords" content="<?= htmlentities ($meta['keywords']) ?>" />
        <meta name="verify-v1" content="BfbaMc3dkDvTDVaqM6p36ELw1XManUY4RwidzYJWvjM=" />
                
        <link type="text/css" rel="stylesheet" href="/_/css/style.css" />
        <link type="text/css" rel="stylesheet" href="/_/css/home.css" />
        <? $this->inc ('common/ieCss.php') ?>
    </head>
    
    <body>
        <div id="content">
            <div id="main">
                <?= $__CONTENT__ ?>
            </div>
            
            <? $this->inc ('common/footer.php') ?>
        </div>
        
    </body>
</html>