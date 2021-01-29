<?php
# BASIC HEADER REQUIREMENTS
// https://developer.wordpress.org/plugins/plugin-basics/header-requirements/

/** EXAMPLE 01
 * Plugin Name:       My Basics Plugin
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            John Smith
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
 */

/** EXAMPLE 02
 * Plugin Name
 *
 * @package           PluginPackage
 * @author            Your Name
 * @copyright         2019 Your Name or Company Name
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Plugin Name
 * Plugin URI:        https://example.com/plugin-name
 * Description:       Description of the plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Your Name
 * Author URI:        https://example.com
 * Text Domain:       plugin-slug
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

/** HEADER FIELDS
- Plugin Name: (required) The name of your plugin, which will be displayed in the Plugins list in the WordPress Admin.
- Plugin URI: The home page of the plugin, which should be a unique URL, preferably on your own website. This must be unique to your plugin. You cannot use a WordPress.org URL here.
- Description: A short description of the plugin, as displayed in the Plugins section in the WordPress Admin. Keep this description to fewer than 140 characters.
- Version: The current version number of the plugin, such as 1.0 or 1.0.3.
- Requires at least: The lowest WordPress version that the plugin will work on.
- Requires PHP: The minimum required PHP version.
- Author: The name of the plugin author. Multiple authors may be listed using commas.
- Author URI: The author’s website or profile on another website, such as WordPress.org.
- License: The short name (slug) of the plugin’s license (e.g. GPLv2). More information about licensing can be found in the WordPress.org guidelines.
- License URI: A link to the full text of the license (e.g. https://www.gnu.org/licenses/gpl-2.0.html).
- Text Domain: The gettext text domain of the plugin. More information can be found in the Text Domain section of the How to Internationalize your Plugin page.
- Domain Path: The domain path lets WordPress know where to find the translations. More information can be found in the Domain Path section of the How to Internationalize your Plugin page.
- Network: Whether the plugin can only be activated network-wide. Can only be set to true, and should be left out when not needed.
 */
