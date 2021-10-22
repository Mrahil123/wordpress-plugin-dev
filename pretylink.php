<?php
/**
 * Plugin Name: AngerText
 * Description: Show who's written what this month on WPShout
 * Version: 1.0
 * Author: WPShout
 * Author URI: https://wpshout.com
*/

class main{
	function __construct(){
		add_filter("the_content",array($this,"theWrap"));
		add_action("admin_menu",array($this,"theAdminMenuSetting"));
		add_action("admin_init",array($this,"settings"));

	}
	function settings(){
		add_settings_section("wcp_first_section",null,null,"admin-word-count-page");

		add_settings_field("wpc_array","add key",array($this,"locationHtml1"),"admin-word-count-page","wcp_first_section");
		register_setting("wordcountplugingrour","wpc_array",array("sanitize_callback"=>"sanitize_text_field","default"=>"key"));

		add_settings_field("wpc_array1","add links",array($this,"locationHtml2"),"admin-word-count-page","wcp_first_section");
		register_setting("wordcountplugingrour","wpc_array1",array("sanitize_callback"=>"sanitize_text_field","default"=>"link"));
	}
	function locationHtml1()

	{

		?>
		<input type="text" name="wpc_array" value="<?php echo get_option("wpc_array") ?>">
		
		<?php
	}
	function locationHtml2()

	{

		?>
		<input type="text" name="wpc_array1" value="<?php echo get_option("wpc_array1") ?>">
		
		<?php
	}

	function theWrap($content){

		$cars = array (
		array("test","<a href='http://google.com'>test</a>"),
		array("bogy","chengedbook"),
		
		$newdata = array (array(get_option("wpc_array"),get_option("wpc_array1")))

		);
		array_push($cars,$newdata);
		$our = $content;

		for($x=0;$x<count($cars) ;$x++){
		$one = $cars[$x][0];
		$tow = $cars[$x][1];
		
		$our = str_replace($one,$tow,$our);
		
		}

		return $our . "<h1>yahoo is king</h1>" . get_option("wpc_array","testing");
	}



	
	function theAdminMenuSetting(){
		add_options_page("word count setting","word count","manage_options","admin-word-count-page",array($this,"viewAdminPage"));
    }
    
	function viewAdminPage(){
		?>
		<div class="wrap">
		<h1>hello admin</h1>
		
		<form action="options.php" method="POST">
		<?php
            settings_fields("wordcountplugingrour");
			do_settings_sections("admin-word-count-page");
			submit_button();
		?>
		</form>
		</div>
		<?php
    }
}

$dothis = new main();