<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title><?= htmlentities ($result['title']) ?> | <?= CLUtil::getCityForClDomain ($result['clb']['clDomain']) ?> (<?= $result['clb']['location'] ?>) <?= ($result['clb']['price']) ? ' | $' . $result['clb']['price'] : '' ?></title>
        <meta name="description" content="<?= htmlentities ($result['title']) ?> | <?= CLUtil::getCityForClDomain ($result['clb']['clDomain']) ?> (<?= $result['clb']['location'] ?>) <?= ($result['clb']['price']) ? ' | $' . $result['clb']['price'] : '' ?>" />
        <? $this->inc ('common/ga.php'); ?>
    </head>
    
    <frameset rows="100px,*">
       <frame src="/fs/?<?= $_SERVER['QUERY_STRING'] ?>" />
       <frame src="<?= $result['link'] ?>" />
    </frameset>
    
</html>