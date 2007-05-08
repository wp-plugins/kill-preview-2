<?php
/*
Plugin Name: Kill Preview 2
Plugin URI: http://www.jovelstefan.de/kill-preview/
Description: Removes the post preview iframe from the post writing screen and adds a preview link.
Author: Stefan He&szlig;
Version: 2.1
Author URI: http://www.jovelstefan.de
License: GPL

The plugin is based on Kill Preview by Owen Winkler: http://redalt.com/Resources/Plugins/Kill+Preview
*/

if((strstr($_SERVER['REQUEST_URI'], 'wp-admin/post.php')) || (strstr($_SERVER['REQUEST_URI'], 'wp-admin/page.php'))) {
	ob_start('kill_preview');
}

function kill_preview($content)
{

	preg_match("/<div[^>]*?id='preview'.*?<\/div>/mis", $content);

	$tmp = preg_match("|http.*?true|", $content, $match);
	$preview_link = $match[0];

	$content = preg_replace("/<div[^>]*?id='preview'.*?<\/div>/mis", '', $content);

	if ( 3664 <= $wp_db_version ) {
		$content = preg_replace('/<a href="#preview-post">/mis', '<a href="'.$preview_link.'" onclick="this.target=\'_blank\';">', $content);
	} else {
		$content = preg_replace('/<div id="moremeta">/', '<div id="moremeta"><a href="'.$preview_link.'" onclick="this.target=\'_blank\';">Post Preview</a>', $content);
	}

	return $content;

}

?>