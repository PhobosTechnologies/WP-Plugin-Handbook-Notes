<?php
# INTERNATIONALIZATION (aka: i18n, cuz nternationalizatio == 18 letters)

# LOCALIZATION (aka: i10n, cuz ocalizatio == 10 letters)
// translating an internationalized plugin

# POT (PORTABLE OBJECT TEMPLATE) FILES
// contains original strings in english of the plugin

# PO (PORTABLE OBJECT) FILES
// translators translate the msgstr section into a language resulting in PO file.
// one PO file per lang

# MO (MACHINE OBJECT) FILES
// Machine readable, compiled version of PO files converted with the msgfmt cli tool.

# GENERATING POT
// POT is first file to give to translator. POT & PO files are technically interchangeable

// gen POT w/ wp-cli:
//     wp i18n make-pot

// can also use the Poedit program
// Grunt Tasks can also do it (grunt-wp-i18n, grunt-pot)

# TRANSLATE PO
// save translated file as: my-plugin-{locale}.mo (local is language code or country code)
// ie: plugin-de_DE.mo & plugin-de_DE.po (for German)

// translate PO manually:
// enter this into text editor:

/*
#: plugin-name.php:123
msgid "Page Title"
msgstr ""
*/

// for German:

/*
#: plugin-name.php:123
msgid "Page Title"
msgstr "Seitentitel"
*/

// can also translate PO w/ Poedit
// there are also online service that can do it

# GENERATE MO FILE
// with cli:
// msgfmt -o filename.mo filename.po

# Find PO files, process each with msgfmt cli and rename the result to MO
// for file in `find . -name "*.po"` ; do msgfmt -o ${file/.po/.mo} $file ; done

# TIPS FOR AWESOME TRANSLATIONS:
// 1. don't "replicate", but "replace" if you know somebody who speaks the lang
// 2. maintain same level of formality
// 3. don't use slang or audience specific terms
// 4. look at other peoples localizations for ideas

# USING LOCALIZATIONS:
// place here: wp-content/languages/plugins/my-plugin-fr_FR.mo
// in wp-config.php, define WPLANG:
//    define ('WPLANG', 'fr_FR');
// go to: wp-admin/options-general.php (or "settings"->"General")
// select language in "Site Languages"
// go to: wp-admin/update-core.php
// click "Update translations" if available
// core translation files are downloaded when available


# HOW TO INTERNATIONALIZE YOUR PLUGIN
// use the Gettext libraries

# TEXT DOMAIN
// Text Domain: unique identifiers for loaded translations
// Text Domain must named after plugin's slug, ie:
//    "my-plugin" OR, if loaded on wordpress.com: wordpress.com/plugins/SLUG
// MUST be all lowercase, NO spaces, use hyphens NOT underscores
// Optionally, Text Domain may be added to plugin's header, ie:
/*
 * Plugin Name: My Plugin
 * Author: Plugin Author
 * Text Domain: my-plugin
 */

# DOMAIN PATH
// domain path is optional IF plugin is in official WP plugin directory
// location for plugin's translation. Defaults to folder in which plugin is found
// ie, if domain path is in directory called 'languages' inside plugin, domain path is:
//    /languages
// header example:
/*
 * Plugin Name: My Plugin
 * Author: Plugin Author
 * Text Domain: my-plugin
 * Domain Path: /languages
 */

# BASIC STRINGS
// strings w/out placeholders or plurals
// use: __('Text to Translate','my-plugin');
__( 'Blog Options', 'my-plugin' );
// to echo translation, use: _e('Text to Translate','my-plugin'); no need to use 'echo'
_e( 'WordPress is the best!', 'my-plugin' );

# VARIABLES
printf(
/* translators: %s: Name of a city */   #<--- hint so translator knows context
	__( 'Your city is %s.', 'my-plugin' ),
	$city
);

// only use single quotes
// use argument swapping if more than one var
printf(
/* translators: 1: Name of a city 2: ZIP code */
	__( 'Your city is %1$s, and your zip code is %2$s.', 'my-plugin' ),
	$city,
	$zipcode
);

# PLURALS
// use _n(singular, plural, count, text_domain)
printf(
	_n(
		'%s comment',
		'%s comments',
		get_comments_number(),
		'my-plugin'
	),
	number_format_i18n( get_comments_number() )
);

// some other languages use singular form for 11, 21, 31, 41, etc.
if ( 1 === $count ) {
	printf( esc_html__( 'Last thing!', 'my-text-domain' ), $count );
} else {
	// sometimes the $count param is used more than once
	printf( esc_html( _n( '%d thing.', '%d things.', $count, 'my-text-domain' ) ), $count );
}

// Pluralize done later
// first, set plural str w/ _n_noop() or _nx_noop()
$comments_plural = _n_noop(
	'%s comment.',
	'%s comments.'
);
// then, later in ur code, use translate_nooped_plural()
printf(
	translate_nooped_plural(
		$comments_plural,
		get_comments_number(),
		'my-plugin'
	),
	number_format_i18n( get_comments_number() )
);

# DISAMBIGUATION BY CONTEXT
_x( 'Post', 'noun', 'my-plugin' );
_x( 'Post', 'verb', 'my-plugin' );
// similar to how __() has echo version _e(), so too does _x() have _ex()
_ex( 'Post', 'noun', 'my-plugin' );
_ex( 'Post', 'verb', 'my-plugin' );

# DESCRIPTIONS
// help translators figure out strings, must start with 'translators:' and be last PHP comment before call
//    ie:
/* translators: draft saved date format, see http://php.net/date */
$saved_date_format = __( 'g:i:s a' );
// also used to explain placeholders in strings
//    ie:
/* translators: 1: WordPress version number, 2: plural number of bugs. */
_n_noop( '<strong>Version %1$s</strong> addressed %2$s bug.','<strong>Version %1$s</strong>strong> addressed %2$s bugs.' );

# NEWLINES
// NEVER USE \r, instead use \n

# EMPTY STRINGS ... don't use them

# ESCAPE ALL STRINGS
// use internationalization escape functions

# BASIC FUNCTIONS:
__();
_e();
_x();
_ex();
_n();
_nx();
_n_noop();
_nx_noop();
translate_nooped_plural();

# TRANSLATE & ESCAPE FUNCTIONS:
esc_html__();
esc_html_e();
esc_html_x();
esc_attr__();
esc_attr_e();
esc_attr_x();

# DATE & NUMBER FUNCTIONS
number_format_i18n();
date_i18n();

# BEST PRACTICES:
// Use decent English style – minimize slang and abbreviations.
// Use entire sentences – in most languages word order is different than that in English.
// Split at paragraphs – merge related sentences, but do not include a whole page of text in one string.
// Do not leave leading or trailing whitespace in a translatable phrase.
// Assume strings can double in length when translated
// Avoid unusual markup and unusual control characters – do not include tags that surround your text
// Do not put unnecessary HTML markup into the translated string
// Do not leave URLs for translation, unless they could have a version in another language.
// Add the variables as placeholders to the string as in some languages the placeholders change position.
printf(
	__( 'Search results for: %s', 'my-plugin' ),
	get_search_query()
);
// Use format strings instead of string concatenation – translate phrases and not words:
printf( __( 'Your city is %1$s, and your zip code is %2$s.', 'my-plugin' ), $city, $zipcode ); is always better than: __( 'Your city is ', 'my-plugin' ) . $city . __( ', and your zip code is ', 'my-plugin' ) . $zipcode;
// Try to use the same words and same symbols so not multiple strings needs to be translated:
__( 'Posts:', 'my-plugin' ); and __( 'Posts', 'my-plugin' );

# ADD TEXT DOMAIN TO EVERY GETTEXT FUNCTION CALL
// in the TOOLS & RESOURCES folder is the add-textdomain.php tool if you ever forget
// run it cli thus:
//    php add-textdomain.php my-plugin my-plugin.php > new-my-plugin.php
// if you don't want a new file output:
//    php /path/to/add-textdomain.php my-plugin my-plugin.php > new-my-plugin.php
// pass in a directory:
//    php add-textdomain.php -i my-plugin my-plugin-directory

# LOADING TEXT DOMAINS
// I'm just going to copy this bullshit:
/**
 * Since WordPress 4.6 translations now take translate.wordpress.org as priority and so plugins
 * that are translated via translate.wordpress.org do not necessary require load_plugin_textdomain()
 * anymore. If you don’t want to add a load_plugin_textdomain() call to your plugin you have to set
 * the Requires at least: field in your readme.txt to 4.6.
 */
// must load MO files with plugin's translations
// load by calling: load_plugin_textdomain() or if plugin is a MUST USE, use: load_muplugin_textdomain()
// this loads {text-domain}-{locale}.mo from plugin's base dir.
// ie:
function my_plugin_load_plugin_textdomain() {
	load_plugin_textdomain( 'my-plugin', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'my_plugin_load_plugin_textdomain' );

# INTERNATIONALIZATION SECURITY
// check for spam in translated strings
// all output strings should be escaped:
esc_html_e( 'The REST API content endpoints were added in WordPress 4.7.', 'your-text-domain' );
// alternatively a translation verification mechanism may be used instead of escaping.
//    ie: all editor role posts must be verified by a trusted editor
// use placeholders for URLs:
printf(
// translators: %1$s is the opening a tag
// translators: %2$s is the closing a tag
	esc_html__( 'Please %1$s register for a WordPress.org account %2$s.', 'your-text-domain' ),
	'<a href="https://wordpress.org/support/register.php">',
	'</a>'
);
// compile your own MO files because fuck trusting the translators
// use msgfmt:
//    msgfmt -cv -o /path/to/output.mo /path/to/input.po
































