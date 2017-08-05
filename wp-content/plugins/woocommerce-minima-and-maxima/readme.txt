=== WooCommerce Minimum/Maximum Order Rules ===
Contributors: DavidAnderson
Requires at least: 3.5
Tested up to: 4.8
Stable tag: 1.6.6
Tags: woocommerce, minimum, maximum
License: GPLv3+
Donate link: http://david.dw-perspective.org.uk/donate

Minimum and maximum order rules for WooCommerce.

== Description ==

This plugin allows a store owner to set rules for minimum and maximum order amounts in WooCommerce.

* Rules for minimum and maximum amounts and total number of items
* Rules can be applied pre-tax or post-tax, pre-discounts or post-discounts (coupons)
* Rules can vary for different shipping (delivery) methods - e.g. stricter rules for delivery than for collection
* Items from specific shipping categories can be exempted from the calculation
* Messages can be shown on the customer's cart and checkout pages
* Items from specific categories can be excluded from the counting
* Optionally allow customers to check-out if *all* their purchased items are excluded from being counted (e.g. they only purchased downloadable goods that don't require shipping)
* Coupon code can be created that exempt customers from the rules

= Other information =

- Some other WooCommerce plugins you may be interested in: https://www.simbahosting.co.uk/s3/shop/

- This plugin is ready for translations, and we would welcome new translations.

== Installation ==

Standard WordPress installation:

- Upload this plugin's zip file into Plugins -> Add New -> Upload in your dashboard; then activate it.

After installation, you will want to configure this plugin, as follows: just go to WooCommerce -> Min/Max Rules

Category settings can be found in Products -> Categories. To create a coupon which exempts the customer from min/max rules (or to edit an existing coupon), go to WooCommerce -> Coupons.

== Frequently Asked Questions ==

= I want to customise the plugin =

The plugin uses standard WordPress/WooCommerce methods to allow developers to customise it - i.e. hooks/filters.

= I want to further customise the message shown to a customer when they are outside of a limit (beyond the possibilities in the dashboard settings) =

A developer can use the wcminandmax_supply_error_message filter that is available in the code.

== Changelog ==

= 1.6.6 - 2017-07-09 =

* TWEAK: Add support for the "Weight Based Shipping" extension, which does not follow WooCommerce conventions for shipping method identifiers
* TWEAK: Update to the current version (0.3) of the WooCommerce_Compat library
* FIX: Detect the shipping method when there is no choice

= 1.6.5 - 2017-05-31 =

* FIX: A wrong regex in the checkout JavaScript could prevent checkout notices from displaying
* TWEAK: Update the bundled updater library

= 1.6.4 - 2017-05-23 =

* FIX: Update the bundled updater library, fixing a bug in it

= 1.6.3 - 2017-04-13 =

* FIX: Prevent duplicate checkout notices on WooCommerce 3.0 when trying to place a disallowed order
* FIX: Category restrictions on product variations were not being applied on WooCommerce 3.0

= 1.6.2 - 2017-03-25 =

* TWEAK: Update woocommerce-compat library version, fixing a bug in meta fetching on WC 3.0
* COMPATIBILITY: Compatible with WooCommerce 3.0

= 1.6.1 - 2017-02-16 =

* TWEAK: Update woocommerce-compat library version, fixing a bug in meta saving on WC 2.7

= 1.6.0 - 2017-02-04 =

* TWEAK: Import woocommerce-compat library to abstract away changes in WC 2.7
* TWEAK: Port all accesses of WC_Order::id and WC_Coupon::id over to woocommerce-compat library
* TWEAK: Port a use of get_post_meta over to woocommerce-compat library

= 1.5.8 - 2017-01-23 =

* Fix: Fix handling of virtual items where no shipping is involved
* Tweak: Use the latest updater class, now managed via composer (including auto-update option)

= 1.5.7 - 2016-11-22 =

* Fix: Fix PHP fatal error on older PHP versions

= 1.5.6 - 2016-11-10 =

* Fix: Display of titles for zone instances using shipping methods in the "Rest of the World" zone were not being handled correctly.
* Fix: When using WC 2.6+ shipping zones, where an instance title had not been entered by the user, the default title was not being shown in the settings
* Tweak: Do not show settings for zone-supporting shipping methods which are not used in any zone

= 1.5.5 - 2016-05-25 =

* FIX: Fix an issue that could cause other extensions to not have the chosen shipping_method accurately passed on to them

= 1.5.4 - 2016-05-13 =

* FIX: Fix an issue with interpretation of options when there were no relevant shipping classes selected, which could lead to incorrect cart errors
* TWEAK: Handling of shipping zones in WC 2.6 has changed: now, per-instance settings are provided, instead of per-zone, allowing more sophisticated setups. After updating (if you previously had WC 2.6, i.e. the beta), you will need to re-save your minimum/maximum settings (even if they have not changed). A dashboard notice will remind you to do this, if relevant.

= 1.5.1 - 2016-05-11 =

* TWEAK: Prevent a PHP notice being generated when a shop has no shipping classes configured
* TWEAK: Prevent a useless SQL call on WooCommerce versions before 2.6

= 1.5 - 2016-04-28 =

* COMPATIBILITY: Updated for compatibility with the forthcoming WooCommerce 2.6, and shipping zones. If/when you upgrade to WooCommerce 2.6, you should immediately set up your shipping zones (if you use shipping) and then re-save your minimum/maximum settings (even if they have not changed - because WC's internals have, and the saved settings need to reflect this). A dashboard notice will remind you to do this.
* FIX: Bug whereby after turning on the 'ignore in min/max purchase' calculation for a category, it could not then be turned off
* FIX: When a particular shipping method's settings were de-activated, those settings should still be filled in the dashboard page inputs (not blanked)

= 1.4.1 - 2016-04-15 =

* TWEAK: 1.4 had debugging turned on, causing information to be sent to the PHP log

= 1.4 - 2016-04-15 =

* FIX: Fix an issue with wrong detection of shipping classes due to changes in how jQuery is serializing unselected options

= 1.3 - 2016-03-08 =

* TWEAK: Add more filters to allow over-riding of the quantity + cost rules

= 1.2 - 2016-02-10 =

* TWEAK: Add a couple of filters to allow some developer customisation

= 1.1 - 2015-10-16 =

* FIX: Deal with checkouts with differently-named shipping widgets
* FIX: Check at check-out did not always fire, due to some erroneously inactive code

= 1.0 - 2015-10-07 =

* RELEASE: Initial release

== License ==

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
