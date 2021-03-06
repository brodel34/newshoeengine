﻿=== Disable Cart Fragments by Optimocha ===
Contributors: optimocha
Tags: disable cart fragments, woocommerce, cart fragments, woocommerce cart fragments
Requires at least: 4.6
Tested up to: 5.2.1
Requires PHP: 5.6
Stable tag: 1.01
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

A better way to disable WooCommerce's cart fragments script, and re-enqueue it when the cart is updated. Works with all caching plugins.

== Description ==

**Disable Cart Fragments** is a lightweight plugin which effectively speeds up your WooCommerce website by disabling the cart fragments script. It also enqueues the script back when the cart is not empty anymore; so it only works while the cart is empty.

= Why is disabling cart fragments important? =

WooCommerce makes an AJAX request to check your cart and update your cart totals in wherever your theme shows cart contents (like the header menu). This AJAX call is made to override caching plugins, which is good, but it generally takes time.

= How does Disable Cart Fragments solve the issue? =

With our plugin, you have the best of both worlds: You keep using the caching plugin *and* you still get to update the cart totals **when the cart is not empty**. This check is made via WooCommerce cart cookies, so it still employs JavaScript but doesn't rely on slow AJAX requests. The check is made instantly, whether you're using a caching plugin or not. How cool is that?

= WooCommerce Optimization Services =

Feel free to reach out to us at [Optimocha.com](https://optimocha.com/?ref=disable-cart-fragments) and let us help you optimize your WooCommerce website!

= Main plugin features =

* Disables WooCommerce cart fragments.
* Checks the cart cookies and if it's not empty, loads the cart fragments script so the cart totals are still updated.
* Brings you joy. (WARNING: Might not bring joy in some rare cases.)

== Installation ==

1. Download the plugin (.zip file) on your hard drive.
2. Unzip the zip file contents.
3. Upload the `disable-cart-fragments` folder to the `/wp-content/plugins/` directory.
4. Activate the plugin through the 'Plugins' menu in WordPress.
5. When activated, it will start working. There's no settings page, simply activate and use.

== Changelog ==

= 1.01 =
* Edited readme.txt to fix the info on the "Installation" section.
* Branded the plugin with a nice little icon.

= 1.0 =
* Initial release