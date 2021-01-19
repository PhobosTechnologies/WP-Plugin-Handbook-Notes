<?php
// PRE-DEFINED SHORTCODES
/*--------------------------------------------------------------------------------------------------------------------*/
// [caption]    – allows you to wrap captions around content
// [gallery]    – allows you to show image galleries
// [audio]      – allows you to embed and play audio files
// [video]      – allows you to embed and play video files
// [playlist]   – allows you to display collection of audio or video files
// [embed]      – allows you to wrap embedded items

// SHORTCODE ALWAYSES :p
/*--------------------------------------------------------------------------------------------------------------------*/
//  always return
//  shortcodes are filters, don't create side-effects
//  prefix your shortcodes
//  sanitize input / escape output
//  provide clear documentation for shortcodes and attributes

// ADDING SHORTCODE
/*--------------------------------------------------------------------------------------------------------------------*/
$tag = 'wporg'; // the shortcode
$function = 'wporg_shortcode'; // the function :D
add_shortcode($tag,$function);

function wporg_shortcode( $atts = array(), $content = null ){
	return "whatever"; // always return
	return $content;
}

// Remove Shortcode
// first check if it exists
if(shortcode_exists($tag)){
	remove_shortcode($tag);
}

// ENCLOSED SHORTCODE CONTENT
/*--------------------------------------------------------------------------------------------------------------------*/
// use is_null() to tell if $content is set to null (aka, self-closing)
?>
[wporg]content[/wporg]
<?php
// the shortcode tags AND the content between will be replaced with return value

// SHORTCODES WITHIN SHORTCODES
/*--------------------------------------------------------------------------------------------------------------------*/
?>
[scode]blah [blah] blah[/scode]
<?php
// execute by calling do_shortcode(content) on content
function wporg_shortcode($atts = array(), $content = null){
	// do something to $content

	// run shortcode parser recursively
	$content = do_shortcode($content);

	// always return
	return $content;
}
add_shortcode('wporg', 'wporg_shortcode');

// shortcode parser cannot handle both [scode] and [scode][/scode] types of the same scode
// must be one or the other

// SHORTCODE PARAMETERS
/*--------------------------------------------------------------------------------------------------------------------*/

?>
[wporg title="WordPress.org"]
Having fun with WordPress.org shortcodes.
[/wporg]
<?php

// shorcode handler functions take 3 parameters
// 1. $atts – array – [$tag] attributes
// 2. $content – string – post content
// 3. $tag – string – the name of the [$tag] (i.e. the name of the shortcode)

function wporg_shortcode( $atts = array(), $content = null, $tag = '' ){
	// normalize attribute keys, lowercase
	$atts = array_change_key_case( (array) $atts, CASE_LOWER );
	// blah blah blah
	$something = atts[0].'taggiton';
	return $something;
}
