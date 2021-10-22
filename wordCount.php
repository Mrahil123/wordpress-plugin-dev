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
        add_action("admin_menu",array($this,"theAdminMenuSetting"));
		add_action("admin_init",array($this,"settings"));
		add_filter("the_content",array($this,"theWrap"));
	}

	function theWrap($content){
		if(is_main_query() AND is_single()  AND
		(get_option("wpc_location2","1") OR
		 get_option("wpc_location3","1") OR
		  get_option("wpc_location4","1"))
		  
		  )
		  {
			return $this->theContentHTML($content);
		  }
		  return $content;
	}
	function theContentHTML($content){
		$body = "<h3>" . esc_html(get_option("wpc_location1","post head man")) . "</h3><p>";

		if(get_option("wpc_location2","1") OR get_option("wpc_location4","1")){
			$wordCound = str_word_count(strip_tags($content));
		}
		
		if(get_option("wpc_location2","1")){
			$body .= "this post have " . $wordCound . " words<br>";
		}
		if(get_option("wpc_location4","1")){
			$body .= "this post have " . strlen(strip_tags($content)) . " charecters<br>";
		}
		if(get_option("wpc_location3","1")){
			$body .= "this post need " . round($wordCound/225) . " to reed<br>";

		}

		$body .= "</p>";

		if(get_option("wpc_location","0")=="0"){
			return $body . $content;
		}
		return $content . $body ;
	}

	function settings(){
		add_settings_section("wcp_first_section",null,null,"admin-word-count-page");

		add_settings_field("wpc_location","where to post",array($this,"locationHtml"),"admin-word-count-page","wcp_first_section");
		register_setting("wordcountplugingrour","wpc_location",array("sanitize_callback"=>"sanitize_text_field","default"=>"0"));
	
		add_settings_field("wpc_location1","titile of ",array($this,"locationHtml1"),"admin-word-count-page","wcp_first_section");
		register_setting("wordcountplugingrour","wpc_location1",array("sanitize_callback"=>"sanitize_text_field","default"=>"Post Headline"));
	
		add_settings_field("wpc_location2","word count",array($this,"locationHtml2"),"admin-word-count-page","wcp_first_section",array("theName"=>"wpc_location2"));
		register_setting("wordcountplugingrour","wpc_location2",array("sanitize_callback"=>"sanitize_text_field","default"=>"1"));
	
		add_settings_field("wpc_location3","read time",array($this,"locationHtml2"),"admin-word-count-page","wcp_first_section",array("theName"=>"wpc_location3"));
		register_setting("wordcountplugingrour","wpc_location3",array("sanitize_callback"=>"sanitize_text_field","default"=>"1"));
	
		add_settings_field("wpc_location4","word characters",array($this,"locationHtml2"),"admin-word-count-page","wcp_first_section",array("theName"=>"wpc_location4"));
		register_setting("wordcountplugingrour","wpc_location4",array("sanitize_callback"=>"sanitize_text_field","default"=>"1"));
	
	}

	function locationHtml2($args)
	{
		?>
		<input type="checkbox" name="<?php echo $args["theName"] ?>" value="1" <?php checked(get_option($args["theName"],"1")) ?>>
		<?php
	}
	function locationHtml()
	{
		
		?>
		<select name="wpc_location">
				<option value="0" <?php selected(get_option('wpc_location'),"0") ?>>up</option>
				<option value="1" <?php selected(get_option('wpc_location'),"1") ?>>down</option>
		</select>
		<?php
	}
	function locationHtml1()
	{
		?>
		
		<input type="text" name="wpc_location1" value="<?php echo esc_attr(get_option('wpc_location1')) ?>">
		<?php
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

$wordCountPage = new Rahil();

