=== wp-config.php SECRET_KEY edit ===

Contributors: activeblogging
Donate link: http://activeblogging.com/member-benefits/
Tags: plugin, SECRET_KEY, security
Requires at least: 2.5
Tested up to: 2.5
Stable tag: 1.03

Add/Change SECRET_KEY in wp-config.php for WP 2.5.x installs

== Description ==

Adds or changes the random SECRET_KEY in your WordPress wp-config.php file, if file permissions allow it. NOT needed on new installs unless you want to change the key; it's useful on upgrades where you're reusing the old wp-config.php file. Just activate. On success the plugin will add the key, log you out, and then deactivate itself. On failure, it will give you a random key to add by hand. Note: if any problems, just delete this file or rename it and refresh your browser.

== Installation ==

1. Upload 'utopia39.php' to your '/wp-content/plugins/' directory
1. Activate the plugin through the 'Plugins' menu in WordPress each time you want the secret key to be added or changed.
1. Your secret key is changed, and the plugin will log you out of the blog, and turn itself off.

== Frequently Asked Questions ==

* What does this do exactly?

The SECRET_KEY value in the wp-config.php file is a new addition since WordPress 2.5, and adds extra security to your blog. On older installs, upgrading does not add the key, so this plugin was written to add the key transparently, or change the key.

* Are there any special requirements?

It is not needed on older blogs (before 2.5). Also, brand new installs will add the key automatically, so it's only needed then if you wish to change the key periodically.

* Where can I read more?

Visit http://ActiveBlogging.com/info/how-to-change-wordpress-secret_key-plugin/




