<?php
# USING SVN (SUBVERSION)
// The WP SVN repo is strictly for release versions - DO NOT USE AS DEVELOPMENT REPO!!!
// Use tags for versioning (just like with git ... well, not *just* like - but ya)
// For more info see: http://svnbook.red-bean.com/
// ... also consider getting a client - might be sorta helpful

# ACCOUNT
// SVN account has same username as what you used to submit the plugin
//    * caps matter

# SVN FOLDERS
// ->: /assets/     ->: for screenshots, plugin headers, and icons
// ->: /tags/       ->: releases
// ->: /trunk/      ->: dev work
// ->: /branches/   ->: divergent branches

# TRUNK DIR
// where the code should live: aka, latest (aka2: not stable probably)!
// try to make sure it at least works
// for really REALLY simple plugins, you can prob live here - but meh

# TAGS
// where you keep versioned code/releases
// use same version num for directory names, ie:
//    v1.0 ->: /tags/1.0
//    v1.2 ->: /tags/1.2
// Semantic Software Versioning is strongly recommended: https://en.wikipedia.org/wiki/Software_versioning

# ASSETS
// Screenshots, header images, icons, etc.

# BRANCHES
// Yeah ... this directory has largely been deprecated and will no longer be auto-created
// BUT, if you want to stick branches in here, go for it

# BEST PRACTICES
// 1. No use SVN for dev (duh ... I mean, who in their right mind would anyway?)
//     |-> When you push, SVN re-builds all of your zipped versions (apparently, taking up to 6 hours sometimes)
// 2. Use TRUNK for your latest code, even if it's beta
// 3. ALWAYS tag and iterate your motherfucking releases, GOD DAMNIT!!!
// 4. Create tags from trunk. Edit in trunk, then tag and version/move it to tags
//     |-> muck it all up locally, THEN push it
// 5. DELETE OLD VERSIONS!!! ... this is a no brainer, but hey

# START NEW PLUGIN
// create local version: mkdir my-local-dir
/** checkout pre-build repo:
$ svn co https://plugins.svn.wordpress.org/your-plugin-name my-local-dir
> A my-local-dir/trunk
> A my-local-dir/branches
> A my-local-dir/tags
> Checked out revision 11325.
 */
// go to my-local-dir and add your files to trunk/
//    |-> also, don't be dumb and put your main plugin dir in trunk
/** tell SVN to add files to main repo:tell SVN to add files to main repo:
$ cd my-local-dir
my-local-dir/ $ svn add trunk/*
> A trunk/my-plugin.php
> A trunk/readme.txt
 */
/** the check changes back in to central repo
my-local-dir/ $ svn ci -m 'Adding first version of my plugin'
> Adding trunk/my-plugin.php
> Adding trunk/readme.txt
> Transmitting file data .
> Committed revision 11326.
 */
// include commit message (yes, just like git ... it's required)
//    You can fix any errors concerning this by adding un and pw:
//    my-local-dir/ $ svn ci -m 'Adding first version of my plugin' --username your_username --password your_password

# EDITING EXISTING FILES
/** First make sure your local copy of the repo is up to date:
$ cd my-local-dir/
my-local-dir/ $ svn up
> At revision 11326.
*/  // NOTE: if there were any discrepancies, SVN would have downloaded and merged it
/** check status of local copy
my-local-dir/ $ svn stat
> M trunk/my-plugin.php
 */ // says trunk/my-plugin.php if different ('M' for "modified")
/** Check for what's different
my-local-dir/ $ svn diff
> * What comes out is essentially the result of a
 * standard `diff -u` between your local copy and the
 * original copy you downloaded.
 */
/** If it's all good, check it all in butt-head!
my-local-dir/ $ svn ci -m "fancy new feature: now you can foo *and* bar at the same time"
> Sending trunk/my-plugin.php
> Transmitting file data .
> Committed revision 11327.
 */
// ALL DONE!

# TAGGING NEW VERSIONS
// each formal release needs to be tagged
// copy code to subdir in tags/ directory (use ver nums for subdirs)
/** uses SVN cp instead of shell cp
my-local-dir/ $ svn cp trunk tags/2.0
> A tags/2.0
*/
/** check in the changes
my-local-dir/ $ svn ci -m "tagging version 2.0"
> Adding         tags/2.0
> Adding         tags/2.0/my-plugin.php
> Adding         tags/2.0/readme.txt
> Committed revision 11328.
*/
// Update Stable Tag field in trunk/readme.txt to newest version

# NOTES
// This ain't no git - just put dev files - no gitignore, no vendor files ... JUST PLUGIN DEV FILES
// also, SVN zips it for you, don't upload pre-zipped shit

