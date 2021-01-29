<?php
# ALERTS & WARNINGS

# APPROVED & PENDING:
// Notice to plugin owner only. After plugin's approved, before any code has been uploaded.
// "This plugin is approved and awaiting data upload but not visible to the public yet. Once you make
//    your first commit, the plugin will become public."

# CLOSED:
// Viewable by all visitors after plugin is closed.
// "This plugin was closed on Month Nth, YEAR and is no longer available for download."
// After 60 days, alert is updated with reason.
// "This plugin was closed on Month Nth, YEAR and is no longer available for download.
//    Reason: Author Request."
// Committers will see the additional note:
// "If you did not request this change, please contact plugins@wordpress.org for a status.
//    All developers with commit access are contacted when a plugin is closed, with the reasons
//    why, so check your spam email too."

# REASONS FOR CLOSED PLUGINS:
/*
 * 1. Author Request:                   Author requested it
 * 2. Guideline Violation:              Violation of any of the guidelines
 * 3. Licensing/Trademark Violation:    Non-GPL code in use or trademark misuse
 * 4. Merged Into Core:                 Plugin now a part of WP core
 * 5. Security Issues:                  Security concern has been found
 */

# OUT OF DATE:
// Plugin must support last 3 major releases of WP; otherwise this notice:
// "This plugin hasn't been tested with the latest 3 major releases of WordPress. It may no longer
//    be maintained or supported and may have compatibility issues when used with more recent versions."
// WP releases major updates 2 to 3 times per year.
// Avoid this message by updating plugin readme when new WP version is released.
// No need to push a new version, simply update readme value of "Tested up to: <LATEST WP VERSION>"

/**
 * =============================================================================================
 */

# DEVELOPER FAQ

# CONTACT PLUGIN TEAM
// plugins@wordpress.org

# ADD PLUGIN
// https://wordpress.org/plugins/developers/add/

# AFTER PLUGIN SUBMISSION
// Plugin will be reviewed and an email will be sent to you before and after review

# PLUGIN APPROVAL TIME-FRAME
// About 14 days for small to med size

# PLUGINS ALLOWED FOR REVIEW AT A TIME
// Just one
// Don't try to get around one-at-a-time rule, you'll get suspended

# THINGS TO AVOID
/** This is NOT a comprehensive list:

1. Not including a readme.txt file when acting as a service
2. Not testing the plugin with WP_DEBUG
3. Including custom versions of packaged JavaScript libraries
4. Calling external files unnecessarily
5. “Powered By” links
6. Phoning home
 */

# NAMING YOUR PLUGIN:
/**
1. Plugins may not use vulgarities in the name or slug
2. Plugins may not use ‘WordPress’ or ‘Plugin’ in their slugs except under extreme situations
3. Plugins may not use version numbers in plugin slugs
4. Due to system limitations, only English letters and Arabic numbers are permitted in the slug
5. Plugins may not start with a trademarked term or name of a specific project/library/tool unless submitted by an official representative
 */

# SVN FILE SYSTEM
// Put readme.txt and root plugin-name.php file directly in trunk/

# NAMING TAGS
// use semantic versioning, ie:
// 2.7.1

# OLD RELEASES
// keep as few as possible in SVN

# ADDING SVN EXTERNALS
// don't add them to your plugin, just the repository

# COMPRESSED FILES
// Do not put zips or other compressed files in your repo

# PLUGIN TAGS
// 5 tags allowed, no more - otherwise it's infringing on the spam rules

# SHOWING UP IN SEARCH
// 6 to 14 days, usually

# GET A HIGH RANKING
// Write a good readme
// Answer support posts promptly
// Get good reviews

# GET NOTIFIED FOR FORUM POSTS
// go here: https://wordpress.org/support/plugin/YOURPLUGIN

# NOTIFICATIONS FOR YOUR PLUGINS
// https://wordpress.org/support/users/YOURID/subscriptions
// https://profiles.wordpress.org/YOURID/profile/notifications/
// RSS: https://wordpress.org/support/view/plugin-committer/YOURID
// Authors, not committers: https://wordpress.org/support/view/plugin-contributor/YOURID

# CLOSE PLUGIN
// go to 'close this plugin' section here: https://wordpress.org/plugins/myplugin/advanced/

# GIVE / TRANSFER ACCESS TO PLUGIN:
// https://wordpress.org/plugins/YOURPLUGIN/advanced

# ADOPT A PLUGIN
// https://developer.wordpress.org/plugins/wordpress-org/take-over-an-existing-plugin/


