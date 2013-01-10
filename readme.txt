=== Christian Science Bible Lesson Subjects ===
Contributors: gserafini
Donate link: http://bit.ly/cs-bible-lesson-plugin-donation
Tags: cs, christian science, subjects, bible lesson, church, widget, sidebar, plugin
Requires at least: 2.7
Tested up to: 3.5
Stable tag: 1.1

Provides configurable widget and shortcode for displaying upcoming weekly Christian Science Bible Lesson subjects.

== Description ==

Display upcoming Christian Science Bible Lesson topics in any widget-enabled sidebar on your site.

= Widget Features: =

* Select number of upcoming subjects to display (default is 3 weeks)
* Select whether to display 'more info' link to [ChristianScience.com](http://christianscience.com/prayer-and-health/the-bible-and-science-and-health/christian-science-bible-lesson "More information about Bible Lessons at ChristianScience.com")
* Configure number of days in advance of Thanksgiving Day service to display explanatory message
* Option to disable Thanksgiving Day message if desired

= Shortcodes: =

Insert `[cs_subject_of_the_week]` into any post or page to insert the default number of upcoming subjects

Optional shortcode parameters

`[cs_subject_of_the_week weeks_to_display="3" display_more_info_link="1" thanksgiving_days_in_advance="30"]`

* weeks_to_display - configure number of weeks in advance to display
* display_more_info_link - Set to '1' to show more info link, '0' to hide (Default)
* thanksgiving_days_in_advance - Set to 0 to disable, or number of days in advance of Thanksgiving Day to show special message


== Installation ==

1. Unzip the ZIP file and drop the folder straight into your wp-content/plugins directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

= Use as a widget =

1. Navigate to 'Appearance' -> 'Widgets'
2. Drag the 'CS Bible Lesson Topics' widget into a sidebar to display in that sidebar
3. Configure widget if you'd like to change the default settings

= Use as a shortcode =

1. Insert `[cs_subject_of_the_week]` into any post or page to insert the default number of upcoming subjects

	Optional shortcode parameters

	`[cs_subject_of_the_week weeks_to_display="3" display_more_info_link="1" thanksgiving_days_in_advance="30"]`

	* weeks_to_display - configure number of weeks in advance to display
	* display_more_info_link - Set to '1' to show more info link, '0' to hide (Default)
	* thanksgiving_days_in_advance - Set to 0 to disable, or number of days in advance of Thanksgiving Day to show special message

2. Publish and  view post or page to see output.

= Use in Templates for Theme authors =

You can use this plugin in your themes if you wish instead of using it as a widget.

Place into your theme to display list of upcoming subjects:
`&lt;?php if (function_exists('stp_getBibleLessonSubjects')) echo stp_getBibleLessonSubjects( 3, true, 30); ?&gt;`

Function parameters are ( weeks_to_display, display_more_info_link, thanksgiving_days_in_advance).  
You can also call the function without parameters and the defaults will be used.

= CSS Classes for adding custom styles =

Add the following declarations to your stylesheet if you'd like to further customize the output of this plugin:

`/* Enclosing div */
.stp_cs_bible_lesson_topics_widget { }

/* span surrounding date in outputted list */
.stp_cs_bible_lesson_topics_date { }

/* span surrounding subject in outputted list */
.stp_cs_bible_lesson_topics_subject { }

/* class on enclosing li tag for more info link */
.stp_cs_bible_lesson_topics_more_info_link { }

/* enclosing class for special Thanksgiving message */
.stp_cs_bible_lesson_topics_thanksgiving_message { }`



== Frequently Asked Questions ==

= Is this provided by the Christian Science Publishing Society? =

No, this has been coded by [ShareThePractice.org](http://sharethepractice.org/) for use by branch churches and societies.

= Is support available? =

Yes, use the contact form on the ShareThePractice.org [website](http://sharethepractice.org/contact/).

== Screenshots ==

1. Widget configuration options 
2. Output of widget in a sidebar

== Changelog ==

= 1.1 =
* Fix to synchronize weekly Bible study lesson topics for 2013

= 1.0 =
* Initial release of plugin

== Upgrade Notice ==

= 1.1 =
* Fix to synchronize weekly Bible study lesson topics for 2013

= 1.0 =
Initial Release

