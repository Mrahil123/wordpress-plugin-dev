<?php
/**
 * Plugin Name: WPShout Show Authorship this Month
 * Description: Show who's written what this month on WPShout
 * Version: 1.0
 * Author: WPShout
 * Author URI: https://wpshout.com
*/

class Rahil{
	function __construct(){
		add_filter("the_content",array($this,"theWrap"));
    }
    function theWrap($content){

    $url = "https://amazonapirahii.herokuapp.com/search/apple?api_key=f49480ceffaa4bd35114480c3c9f21a5";
    $json = file_get_contents($url);
    $json_data = json_decode($json, true);
    // echo "My token: ". $json_data["name"];  

	
		return $content . $json_data["name"] .$json_data["name"]pricing ;
	}
} 

$wordCountPage = new Rahil();
