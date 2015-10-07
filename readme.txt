=== WPGlobus - Multilingual Everything! ===
Contributors: tivnetinc, alexgff, tivnet
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=SLF8M4YNZHNQN
Tags: bilingual, globalization, i18n, international, l10n, localization, multilanguage, multilingual, language switcher, translate, translation, WPGlobus
Requires at least: 4.2
Tested up to: 4.3.2
Stable tag: trunk
License: GPLv2
License URI: https://github.com/WPGlobus/WPGlobus/blob/master/LICENSE

Multilingual / Globalization: URL-based multilanguage; easy translation interface, compatible with Yoast SEO, All in One SEO Pack and ACF!

== Description ==

**WPGlobus** is a family of WordPress plugins assisting you in making bilingual / multilingual WordPress blogs and sites.

> **WPGlobus**

The **WPGlobus Free Core plugin** provides you with the main multilingual tools.

* **Manually translate** posts, pages, categories, tags menus and widgets; **NOTE: WPGlobus does NOT translate texts automatically!** To see how it works, please read the [Quick Start Guide](http://www.wpglobus.com/quick-start/);
* **Add one or several languages** to your WP blog / site using custom combinations of country flags, locales and language names;
* **Enable multilingual SEO features** of Yoast SEO and All in One SEO plugins;
* **Switch the languages at the front-end** using: a drop-down menu extension and/or a customizable widget with various display options;
* **Switch the Administrator interface language** using a top bar selector;

The WPGlobus plugin serves as the **foundation** to other plugins in the family.

> **Free Add-ons**

* [WPGlobus Featured Images](https://wordpress.org/plugins/wpglobus-featured-images/): allows setting featured images separately for each language.
* [WPGlobus Translate Options](https://wordpress.org/plugins/wpglobus-translate-options/): enables selective translation of the `wp_options` table strings. You need to use it when your theme or a 3rd party plugin (a slider, for example) has its own option panel, where you enter texts.
* [WPGlobus for WPBakery Visual Composer](https://wordpress.org/plugins/wpglobus-for-wpbakery-visual-composer/): enables WPGlobus on certain themes that use WPBakery's Composer. Please note that Visual Composer is a commercial product, and therefore our support is limited.
* [WPGlobus for Black Studio TinyMCE Widget](https://wordpress.org/plugins/wpglobus-for-black-studio-tinymce-widget/): adds multilingual editing capabilities to the visual editor widget.

> **Premium Extensions**

* [WooCommerce WPGlobus](http://www.wpglobus.com/shop/extensions/woocommerce-wpglobus/): adds multilingual capabilities to WooCommerce-based online stores.
* [WPGlobus Plus](http://www.wpglobus.com/shop/extensions/wpglobus-plus/): adds URL fine-tuning, publishing status per translation, multilingual Yoast SEO analysis and more.

= Compatibility with Themes =

WPGlobus works correctly with all themes that apply proper filtering before outputting content.
Some themes incorporate 3rd party plugins (e.g., sliders, forms, composers) - not all of them are 100% multilingual-ready. When you see elements that cannot be translated, please let the theme / plugin authors know. We are ready to help them.

More information:

* [WPGlobus Compatibility with Themes and Plugins](http://www.wpglobus.com/documentation/wpglobus-compatibility-with-themes-and-plugins/)
* [WPGlobus Configuration File and a Theme Configuration Case Study](http://www.wpglobus.com/documentation/wpglobus-configuration-file/)

= Permalinks =

**IMPORTANT:** WPGlobus will not work if your URLs look like `example.com?p=123` or `example.com/index.php/category/post/`.

Please go to `Settings->Permalinks` and change the permalink structure to non-default and with no `index.php` in it. If you are unable to do that for some reason, please talk to your hosting provider / systems administrator.

= Developing on `localhost` or custom ports =

WPGlobus may not work correctly on development servers having URLs like `//localhost/mysite` or on custom ports like `//myserver.dev:3000`. Please use a proper domain name (a fake one from `/etc/hosts` is OK) and port 80.

= Admin interface translations: =

[WP-Translations](http://wp-translations.org/)

* `de_DE` : Tobias Hopp, [http://www.tobiashopp.info/](http://www.tobiashopp.info/)
* `es_ES` : Patricia Casado, [mascositas.com](http://mascositas.com/)
* `tr_TR` : Borahan Conkeroglu, [@boracon68](https://twitter.com/boracon68)
* `fr_FR` : FX Bénard, [WP-Translations](http://wp-translations.org/)
* `sv_SE` : Elger Lindgren, [Bilddigital](http://bilddigital.se/)
* `pl_PL` : [Maciej Gryniuk](http://maciej-gryniuk.tk/)
* `ru_RU` : The WPGlobus Team (мы говорим по-русски!)

**Please help us translate WPGlobus into your language!** Join the WP-Translations Team on [Transifex](https://www.transifex.com/wp-translations/wpglobus-multilingual/).

= More info and ways to contact the WPGlobus Development Team =

* [WPGlobus.com website](http://www.wpglobus.com/).
* [Open source code on GitHub](https://github.com/WPGlobus).
* WPGlobus on social networks:
	* [Facebook](https://www.facebook.com/WPGlobus)
	* [Twitter](https://twitter.com/WPGlobus)
	* [Google Plus](https://plus.google.com/+Wpglobus)
	* [LinkedIn](https://www.linkedin.com/company/wpglobus)

== Installation ==

You can install this plugin directly from your WordPress dashboard:

1. Go to the *Plugins* menu and click *Add New*.
1. Search for *WPGlobus*.
1. Click *Install Now* next to the WPGlobus plugin.
1. Activate the plugin.

Alternatively, see the guide to [Manually Installing Plugins](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).

Then please read the [Quick Start Guide](http://www.wpglobus.com/quick-start/).

== Frequently Asked Questions ==

= Please read these first: =

* [The Quick Start Guide](http://www.wpglobus.com/quick-start/)
* [Before contacting Support...](http://www.wpglobus.com/before-contacting-wpglobus-support/)

From the [WPGlobus FAQ Archives](http://www.wpglobus.com/faq/):

* [Do you support PHP 5.x?](http://www.wpglobus.com/faq/support-php-5-2/)
* [Do you support MSIE / Opera / Safari / Chrome / Firefox - Version x.x?](http://www.wpglobus.com/faq/support-msie-opera-safari-chrome-firefox/)
* [Do you plan to support subdomains and URL query parameters?](http://www.wpglobus.com/faq/subdomains-and-url-query-parameters/)
* [I am using WPML (qTranslate, Polylang, Multilingual Press, etc.). Can I switch to WPGlobus?](http://www.wpglobus.com/faq/i-am-using-wpml-qtranslate-polylang-multilingual-press-etc-can-i-switch-to-wpglobus/)
* [Do you plan to support WooCommerce, EDD, other e-Commerce plugins?](http://www.wpglobus.com/faq/support-woocommerce-edd/)
* [Is it possible to set the user's language automatically based on IP and/or browser language?](http://www.wpglobus.com/faq/set-language-by-ip/)
* [How do I contribute to WPGlobus?](http://www.wpglobus.com/faq/how-do-i-contribute-to-wpglobus/)

== Screenshots ==

1. Welcome screen.
2. Settings panel.
3. Languages setup.
4. Attaching language switcher to a menu.
5. Editing post in multiple languages.
6. Multilingual Yoast SEO and Featured Images.
7. Language Switcher widget and Multilingual Editor dialog.
8. Multilingual WooCommerce store powered by [WooCommerce WPGlobus](http://www.wpglobus.com/shop/extensions/woocommerce-wpglobus/).

== Upgrade Notice ==

No known backward incompatibility issues.

== Changelog ==

= 1.2.9 =

* FIXED:
	* Correct extracting domain_tld for two-part TLDs like `.co.uk`.
	* Customizer error. Thanks to [shark0der](https://wordpress.org/support/profile/shark0der).
* ADDED:
	* `pl_PL` admin interface translation.
	* `wpglobus-config.json` configuration file for theme options, with WPML compatibility.
	* `wpglobus-current-language` CSS class to the menu.

= 1.2.8 =

* FIXED:
	* Minor admin JS bug.

= 1.2.7 =

* FIXED:
	* Updater bug "cannot delete old plugin files".
	* Broken Welsh flag cy.png (Thanks to Tudor Thomas).

= 1.2.6 =

* FIXED:
	* `de_DE` admin interface properly translated.
	* Broken links to WPGlobus.com from admin pages.
* ADDED:
	* `tr_TR` admin interface translation.
	* `es` and `fr` enabled by default.
* COMPATIBILITY:
	* All In One SEO Pack 2.2.7.2
	* ACF Pro 5.3.0

= 1.2.5 =

* FIXED:
	* Core filters refactored to better support sites with no English.
	* Multilingual Excerpt metaboxes styled to 4-lines height.
	* Several code changes related to WordPress and 3rd party plugin upgrades.
* ADDED:
	* Core support for the Black Studio TinyMCE widget.

= Earlier versions =

* [See the complete changelog here](https://github.com/WPGlobus/WPGlobus/blob/master/changelog.md)

= WooCommerce-WPGlobus =

* [See the changelog here](http://www.wpglobus.com/extensions/woocommerce-wpglobus/woocommerce-wpglobus-changelog/)

== Demo Sites ==

* [WPGlobus.com](http://www.wpglobus.com/):
	* Bilingual site using a variety of posts, pages, custom post types, forms, a slider and a WooCommerce store with Subscription and API extensions.
* [Site in subfolder](http://demo-subfolder.wpglobus.com/):
	* Demonstration of two WPGlobus-powered sites, one of which is installed in a subfolder of another. Shows the correct behavior of WPGlobus with URLs like `example.com/folder/wordpress`.
* [WooCommerce Multilingual](http://demo-store.wpglobus.com/):
	* A **multilingual WooCommerce** site powered by the `woocommerce-wpglobus` plugin.

