=== StatsFC Fixtures ===
Contributors: willjw
Donate link:
Tags: widget, football, soccer, fixtures, premier league, fa cup, league cup
Requires at least: 3.3
Tested up to: 6.2.2
Stable tag: 3.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This widget will display a list of football fixtures on your website, for a chosen competition or team.

== Description ==

Add a list of football fixtures to your WordPress website. To request a key sign up for your free trial at [statsfc.com](https://statsfc.com/sign-up).

For a demo, check out [wp.statsfc.com/fixtures](https://wp.statsfc.com/fixtures/).

= Translations =
* Bahasa Indonesia
* Dansk
* Deutsch
* Eesti
* Español
* Français
* Hrvatski Jezik
* Italiano
* Magyar
* Norsk bokmål
* Slovenčina
* Slovenski Jezik
* Suomi
* Svenska
* Türkçe

If you're interested in translating for us, please get in touch at [hello@statsfc.com](mailto:hello@statsfc.com) or on Twitter [@StatsFC](https://twitter.com/StatsFC).

== Installation ==

1. Upload the `statsfc-fixtures` folder and all files to the `/wp-content/plugins/` directory
2. Activate the widget through the 'Plugins' menu in WordPress
3. Drag the widget to the relevant sidebar on the 'Widgets' page in WordPress
4. Set the StatsFC key and any other options. If you don't have a key, sign up for free at [statsfc.com](https://statsfc.com)

You can also use the `[statsfc-fixtures]` shortcode, with the following options:

* `key` (required): Your StatsFC key
* `competition` (required*): Competition key, e.g., `EPL`
* `team` (required*): Team name, e.g., `Liverpool`
* `group` (optional): Group name, e.g., `Group A`
* `season` (optional): Season to show fixtures for, e.g., `2016/2017`
* `from` (optional): Date to show fixtures from, e.g., `2014-01-01`
* `to` (optional): Date to show fixtures to, e.g., `2014-01-07`
* `limit` (optional): Maximum number of fixtures to show, e.g., `4`, `10`
* `highlight` (optional): The name of the team you want to highlight, e.g., `Liverpool`
* `show_badges` (optional): Display team badges, `true` or `false`
* `show_dates` (optional): Display match dates, `true` or `false`
* `timezone` (optional): The timezone to convert match times to, e.g., `Europe/London` ([complete list](https://php.net/manual/en/timezones.php))
* `default_css` (optional): Use the default widget styles, `true` or `false`
* `omit_errors` (optional): Omit error messages, `true` or `false`

*Only one of `competition` or `team` is required.

== Frequently asked questions ==



== Screenshots ==



== Changelog ==

= 3.1.0 =
* Feature: Allow fixtures to be shown for a specific group via the new `group` parameter

= 3.0.0 =
* Refactor: Update plugin for new API

= 2.15.2 =
* Hotfix: Prevent match times from wrapping

= 2.15.1 =
* Hotfix: Possible issue loading language/CSS files

= 2.15.0 =
* Feature: Allow fixtures to be shown for a specific season via the new `season` parameter

= 2.14.3 =
* Hotfix: Check options exist before using them

= 2.14.2 =
* Hotfix: Check highlight value against short and full team names

= 2.14.1 =
* Hotfix: Check the before/after widget/title bits exist before using them

= 2.14.0 =
* Feature: Moved match times in between the two teams instead of on the left

= 2.13.0 =
* Feature: Translate dates if using non-English

= 2.12.2 =
* Hotfix: Load relevant language file based on the default language for the site

= 2.12.1 =
* Hotfix: Fixed missing team badges

= 2.12.0 =
* Feature: Added multi-language support. If you're interested in translating for us, please get in touch at [hello@statsfc.com](mailto:hello@statsfc.com)

= 2.11.2 =
* Hotfix: Added a responsive horizontal scroll if the widget is too wide for mobile

= 2.11.1 =
* Hotfix: Fixed possible `Undefined index: omit_errors` error

= 2.11.0 =
* Feature: Put CSS/JS files back into the local repo
* Hotfix: Enqueue style/script directly instead of registering first

= 2.10.0 =
* Feature: Added `omit_errors` parameter
* Feature: Load CSS/JS remotely

= 2.9.2 =
* Hotfix: Fixed "Invalid domain" bug caused by referal domain

= 2.9.1 =
* Hotfix: Fixed bug with multiple widgets on one page

= 2.9.0 =
* Feature: Added `highlight`, `show_badges` and `show_dates` options

= 2.8.0 =
* Feature: Re-use the same JS as the standard widget

= 2.7.0 =
* Feature: Allow more discrete ads for ad-supported accounts

= 2.6.0 =
* Feature: Enabled ad-support

= 2.5.0 =
* Feature: Added badge class for each team

= 2.4.0 =
* Feature: Default `default_css` parameter to `true`

= 2.3.0 =
* Feature: Updated team badges.

= 2.2.0 =
* Feature: Added `[statsfc-fixtures]` shortcode.

= 2.1.0 =
* Feature: Tweaked CSS.

= 2.0.0 =
* Feature: Updated to use the new API.

= 1.7.0 =
* Feature: Allow an actual timezone to be selected.

= 1.6.2 =
* Hotfix: Tweaked error message.

= 1.6.1 =
* Hotfix: Fixed possible Timezone bug.

= 1.6.0 =
* Feature: Added fopen fallback if cURL request fails.

= 1.5.1 =
* Hotfix: Fixed possible cURL bug.

= 1.5.0 =
* Feature: Use cURL to fetch API data if possible.

= 1.4.0 =
* Hotfix: Fixed timezone adjustment bug in old versions of PHP. If using an old version, you'll need to choose your own UTC offset in the options.
* Feature: Added Community Shield fixtures.

= 1.3.0 =
* Feature: Automatically adjust kick-off times according to your site's timezone setting.

= 1.2.1 =
* Hotfix: Fixed a bug when selecting a specific team.

= 1.2.0 =
* Feature: Added a setting for number of fixtures. Applies to single team only. Choose `0` to display all fixtures.

= 1.1.0 =
* Feature: If showing fixtures for a single team, highlight that team.

= 1.0.2 =
* Hotfix: Fixed 'Team' setting bug.

= 1.0.1 =
* Hotfix: Fixed syntax error.

= 1.0.0 =
* Feature: Initial widget release.

== Upgrade notice ==

