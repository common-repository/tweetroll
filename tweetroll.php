<?php
/*
Plugin Name: TweetRoll
Plugin URI: http://tweetburn.com/tools/tweetroll/
Description: Displays your TweetRoll - A widget which shows your Twitter details and friends
Version: 1.6
Author: Owen Cutajar
Author URI: http://www.u-g-h.com/
*/

/*
Arguments:
     $username - Your username
     
Updates:
   16th January  2009  - Improved CSS to prevent potential conflicts with some templates
    1st February 2009  - Introduced customisation
   16th February 2009  - Caption customisation    
   15th December 2009  - Sponsored Tweets integration
*/

function tweetroll( $username='' ) {
    $output = '<div align="center"><script type="text/javascript" src="http://tweetburn.com/TweetRoll.php?username='.$username.'"></script></div>';
    
    echo $output;
}

function widget_tweetroll_init() {
	if (!function_exists('register_sidebar_widget')) return;

	function widget_tweetroll($args) {
		
		extract($args);

		$options = get_option('widget_tweetroll');
		$title = $options['title'];
		
		echo $before_widget . $before_title . $title . $after_title;
		tweetroll ( $options['username'] );
		echo $after_widget;
	}

	function widget_tweetroll_control() {
		$options = get_option('widget_tweetroll');
		if ( !is_array($options) )
			$options = array(	'title'=>'TweetRoll', 'username'=>'' );
		if ( $_POST['tweetroll-submit'] ) {
			$options['title'] = strip_tags(stripslashes($_POST['tweetroll-title']));
			$options['username'] = strip_tags(stripslashes($_POST['tweetroll-username']));

			update_option('widget_tweetroll',$options);
		}

		$title = htmlspecialchars($options['title'], ENT_QUOTES);
		$username = htmlspecialchars($options['username'], ENT_QUOTES);
				
		echo '<p style="text-align:right;"><label for="tweetroll-title">Title: <input style="width: 300px;" id="tweetroll-title" name="tweetroll-title" type="text" value="'.$title.'" /></label></p>';
		echo '<p style="text-align:right;"><label for="tweetroll-username">Twitter Username: <input style="width: 300px;" id="tweetroll-username" name="tweetroll-username" type="text" value="'.$username.'" /></label></p>';
		
		echo '<p style="text-align:left;"><a href="http://tweetburn.com/tools/tweetroll-custom/" target="_blank">Change size, colour and captions</a></p>';
		
		echo '<input type="hidden" id="tweetroll-submit" name="tweetroll-submit" value="1" />';
	}		

	register_sidebar_widget('TweetRoll', 'widget_tweetroll');
	register_widget_control('Tweetroll', 'widget_tweetroll_control', 310, 105);
}

add_action('plugins_loaded', 'widget_tweetroll_init');

?>