<?php
session_start();
//Security Check
if(count(get_included_files()) ==1) exit("No direct script access allowed.");
/**
   *Config file for Instagram Downloader
 */
//Current Version
define("VERSION", "2.3");

//True to enable ads and false to disable ads
define("ADS", TRUE);

//Your site URL where script is installed - Must end with slash
define("SITE_URL", '/');

//Instagram Proxies - See Documentation on How to setup Proxies.
define("INSTA_PROXIES", dirname(__FILE__).'/proxies/proxies.txt');
define("INSTA_LOG", dirname(__FILE__).'/proxies/log.txt');
 
$config = array(
    // Tag line after title
    "tag-line" => " -  Instagram Video Downloader, Instagram Video Downloader, Instagram Video Downloader,Instagram Video Downloader,Instagram Video Downloader,Instagram Video Downloader,Instagram Video Downloader,Instagram Video Downloader,Instagram Video Downloader,Instagram Video Downloader,Instagram Video Downloader,Instagram Video Downloader,Instagram Video Downloader,Instagram Video Downloader,Instagram Video Downloader,Instagram Video Downloader,Instagram Video Downloader,",
	
    // Your Site Description
    "description" => "Instagram Downloader",
	
    /** Google Analytics id, should be in this format:
	UA-12345678-1
	*/
    "ga" => "UA-12345678-1",
	
	
	/**
       *Ads config
	 */
    /*Responsive for both desktop and mobile
		ad size 728x90
	*/
    "ad728" => '<img src="https://dummyimage.com/728x90/E1306C/fff" class="img-fluid">',
	
	
	/*Responsive for both desktop and mobile
		ad size 468x60
	*/
    "ad468" => '<img src="https://dummyimage.com/468x60/833AB4/fff" class="img-fluid">',
	
	
	/*Responsive for both desktop and mobile
		ad size 300x250
	*/
    "ad300" => '<img src="https://dummyimage.com/300x250/833AB4/fff" class="img-fluid">'
);
	
	
require_once("core/config-core.php");
require_once("core/vendor/autoload.php");
?>
