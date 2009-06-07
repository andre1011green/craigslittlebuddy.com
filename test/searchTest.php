<?
	require ('../Util/SearchUtil.php');
	require ('../Service/SearchService.php');
	
	$options = array (
			'query' => 'Gibson "les paul"',
			'minAsk' => 20000,
		);
	
	$domains = array ('sfbay', 'newyork');
	$type = 'msg';

	$ss = new SearchService ($options, $type, $domains);
	$ss->search ();
	
	$options['query'] = '"Les  paul" giBSON';
	$ss = new SearchService ($options, $type, $domains);
	$ss->search ();	
?>