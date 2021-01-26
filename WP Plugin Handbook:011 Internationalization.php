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
//
