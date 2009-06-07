<?
/**
 * Most of the code for this site is pretty bad... its not horrible but, it works.
 * 
 * - Arin
 */
 
// error_reporting (E_ALL);
    
/*
 * Where do you want the craigslist search results to be cached to?
 *
 * set MAGPIE_CACHE_DIR to the directory you want the craigslist rss results to be saved in
 * this folder MUST be writeable by the user your webserver's running as
 * The line below will set it to the "cache" sub-folder in the root of this package
 */
define('MAGPIE_CACHE_DIR', realpath (dirname(__FILE__) . '/../cache'));

/*
 * How long do you want craigslist results to be cached for?
 *
 * set MAGPIE_CACHE_AGE to # of seconds you want craigslist results to be cached for
 */
define('MAGPIE_CACHE_AGE', 60 * 60);

// quick include_path setup so you dont have to do it in your apache conf etc
set_include_path (
    get_include_path() . 
    PATH_SEPARATOR . 
    realpath ($_SERVER['DOCUMENT_ROOT'] . '/../') .
    PATH_SEPARATOR . 
    realpath ($_SERVER['DOCUMENT_ROOT'] . '/../ext/magpieRss')
);

// get it started

require_once ('Duckk/Duckk_BaseFramework.php');
$FRAMEWORK = new Duckk_WebDispatcher ($_SERVER['SCRIPT_URL']);
?>