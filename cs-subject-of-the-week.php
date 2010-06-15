<?php
/*
Plugin Name: Christian Science Bible Lesson Subjects
Plugin URI: http://sharethepractice.org/plugins/cs-subject-of-the-week/
Description: Display upcoming Christian Science Bible Lesson subjects in a widget or using shortcode [cs_subject_of_the_week]
Donate URI: http://bit.ly/cs-bible-lesson-plugin-donation
Author: Gabriel Serafini (ShareThePractice.org)
Author URI: http://sharethepractice.org/
Version: 1.0

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

*/ 


/**
 * Return Bible Lesson subject for a given week number
 *
 * Note that in some years this may need to be adjusted when there is an extra
 * week in the year that may be filled with an arbitrary other lesson subject
 * 
 * @param string $date_to_use Optional. Uses any valid strtotime value
 * @return string Subject for a given week of the year
 */
function stp_getSubject($date_to_use='now') {

	// Array of Christian Science Bible Lesson subjects 
	$cs_lesson_subjects = array(
		"God",
		"Sacrament",
		"Life",
		"Truth",
		"Love",
		"Spirit",
		"Soul",
		"Mind",
		"Christ Jesus",
		"Man",
		"Substance",
		"Matter",
		"Reality",
		"Unreality",
		"Are Sin, Disease, and Death Real?",
		"Doctrine of Atonement",
		"Probation After Death",
		"Everlasting Punishment",
		"Adam and Fallen Man",
		"Mortals and Immortals",
		"Soul and Body",
		"Ancient and Modern Necromancy, <i>alias</i> Mesmerism and Hypnotism, Denounced",
		"God the Only Cause and Creator",
		"God the Preserver of Man",
		"Is the Universe, Including Man, Evolved by Atomic Force?",
		"Christian Science");
	
	// repeat the array since lesson subjects are repeated twice a year in the same order
	$cs_lesson_subjects = array_merge($cs_lesson_subjects, $cs_lesson_subjects);

	// Get the lesson for the upcoming next Sunday for any given date 
	$week_num = (int) date('W', strtotime('next Sunday', strtotime($date_to_use)));

	// We have week #0-51 in array. weeks #52 and 53 should roll back to first subject
	if ($week_num >= 52) $week_num = 0;

	return $cs_lesson_subjects[$week_num];

}


/**
 * Display message about next Thanksgiving Day service
 *
 * @param int $thanksgiving_days_in_advance Optional. Number of days in advance to display message
 * @return mixed - String if date is within next $days_in_advance, false if not
 */
function stp_getThanksgivingMessage( $thanksgiving_days_in_advance = 30 ) {

	// Allow widget to disable display of Thanksgiving message
	if ($thanksgiving_days_in_advance == 0) return false;

	$thanksgiving_message = false;

	// Seconds from Jan. 1st, 1970 to Thanksgiving of current year
	$secstoThksgvg = strtotime("3 weeks thursday", mktime(0, 0, 0, 11, 1, date(Y)));

	// Seconds from Jan. 1st, 1970 to current day
	$secstoNow = strtotime("now");

	// Seconds until Thanksgiving from now
	$secstoThksgvg = $secstoThksgvg - $secstoNow;
	
	// Seconds before Thanksgiving when user wants alert to activate
	$secsbforThksgvg = $thanksgiving_days_in_advance * 86400;

	// If days until Thanksgiving falls within range given by user, display notice
	if ($secsbforThksgvg > $secstoThksgvg && $secstoThksgvg >= 0) {

		$thanksgiving_date = date("d", strtotime("3 weeks thursday", mktime(0, 0, 0, 11, 1, Date(Y)))). "th, " . Date(Y);

		$thanksgiving_message  = '';
		$thanksgiving_message .= '<strong>Join us for a special Thanksgiving Service!</strong><br />';
		$thanksgiving_message .= 'Christian Science Churches in the United States will be holding a service on Thanksgiving Day, November&nbsp;' .  $thanksgiving_date . '.';

	}

	return $thanksgiving_message;

}

/**
 * Return HTML formatted list of Bible Lesson topics
 *
 * @param int $weeks_to_display Optional. Number of weeks to display
 * @param bool $display_more_info_link Optional. Display more info link or not
 * @param int $thanksgiving_days_in_advance Optional. Number of days in advance to display message
 * @return string
 */
function stp_getBibleLessonSubjects( $weeks_to_display = 3, $display_more_info_link = '0', $thanksgiving_days_in_advance = 30 ) {

	$output  = "";
	$output .= '<div class="stp_cs_bible_lesson_topics_widget">';
	$output .= '<ul>';

	for ($n=0; $weeks_to_display > $n; $n++) {

		$output .= '<li>';
		$date_to_use = 'now + ' . $n . 'week'; 
		$output .= '<span class="stp_cs_bible_lesson_topics_date">' . date('n/j/Y', strtotime('next Sunday', strtotime($date_to_use))) . '</span> - <span class="stp_cs_bible_lesson_topics_subject">' . stp_getSubject($date_to_use) . '</span>';
		$output .= '</li>';

	}

	if ('1' == $display_more_info_link) {
		$output .= '<li class="stp_cs_bible_lesson_topics_more_info_link"><a href="http://www.spirituality.com/bible-lesson/" target="_blank">More info about the Bible Lesson &raquo;</a></li>';
	}

	$output .= '</ul>';
	
	$thanksgiving_message = stp_getThanksgivingMessage($thanksgiving_days_in_advance);

	if ($thanksgiving_message) {

		$output .= '<ul class="stp_cs_bible_lesson_topics_thanksgiving_message">';			
		$output .= '<li>' . $thanksgiving_message . '</li>';
		$output .= '</ul>';
	}

	$output .= '</div>';
	
	return $output;

}

/**
 * Shortcode functionality
 *
 * @param mixed $atts Optional. Attributes to use in shortcode
 * @return HTML for list
 */
function stp_cs_subject_of_the_week_shortcode($atts) {

	extract(shortcode_atts(array(
		'weeks_to_display' => '3',
		'display_more_info_link' => 'false',
		'thanksgiving_days_in_advance' => '30',
	), $atts));

	return stp_getBibleLessonSubjects($weeks_to_display, $display_more_info_link, $thanksgiving_days_in_advance);
}

// Register shortcode
add_shortcode('cs_subject_of_the_week', 'stp_cs_subject_of_the_week_shortcode');

/**
 * Add plugin page links
 */
function set_plugin_meta($links, $file) {
 
	$plugin = plugin_basename(__FILE__);
 	$donate_url = 'http://bit.ly/cs-bible-lesson-plugin-donation';
 
	// create link
	if ($file == $plugin) {
		return array_merge(
			$links,
			array( sprintf( '<a href="%s" title="Thank you for supporting Open Source development and maintenance of this plugin!" target="_blank"><strong>%s :)</strong></a>', $donate_url, __('Donate') ) )
		);
	}
 
	return $links;
}

// Activate additional plugin links
add_filter( 'plugin_row_meta', 'set_plugin_meta', 10, 2 );


/**
 * Define our widget
 */
class STP_CS_Bible_Lesson_Topics extends WP_Widget {

	/**
	 * Set up widget options
	 */
	function STP_CS_Bible_Lesson_Topics() {
		$widget_ops = array('classname' => 'widget_text', 'description' => __('List upcoming Bible Lesson topics'));
		$control_ops = array('width' => 200, 'height' => 90);
		$this->WP_Widget('widget-stpcslessonsubject', __('CS Bible Lesson Topics'), $widget_ops, $control_ops);
	}

	/**
	 * Output contents of widget into a sidebar
	 *
	 * @param mixed $args Standard input
	 * @param object $instance Specific instance of this widget
	 * @return string Outputs HTML for sidebar widget
	 */
	function widget( $args, $instance ) {

		extract($args);

		$title = apply_filters( 'widget_title', empty($instance['title']) ? __('Upcoming Bible Lessons') : $instance['title'], $instance );
		$weeks_to_display = apply_filters( 'widget_text', empty($instance['weeks_to_display']) ? __('3') : $instance['weeks_to_display'], $instance );
		$thanksgiving_days_in_advance = apply_filters( 'widget_text', empty($instance['thanksgiving_days_in_advance']) ? __('30') : $instance['thanksgiving_days_in_advance'], $instance );
		$display_more_info_link = apply_filters( 'widget_text', empty($instance['display_more_info_link']) ? 1 : $instance['display_more_info_link'], $instance );

		// Output widget as long as we have at least 1 week's topic to display
		if ($weeks_to_display > 0) {

			echo $before_widget;
			if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }
			echo stp_getBibleLessonSubjects($weeks_to_display, $display_more_info_link, $thanksgiving_days_in_advance);
			echo $after_widget;
		}

	}

	/**
	 * Update widget options
	 *
	 * @param object $new_instance
	 * @param object $old_instance
	 * @return object $instance object
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['weeks_to_display'] = strip_tags($new_instance['weeks_to_display']);
		$instance['thanksgiving_days_in_advance'] = strip_tags($new_instance['thanksgiving_days_in_advance']);
		$instance['display_more_info_link'] = isset($new_instance['display_more_info_link']);

		return $instance;
	}

	/**
	 * Output widget option form in backend Widgets admin
	 *
	 * @param object $instance
	 * @return string Outputs widget options HTML
	 */
	function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );

		$title = apply_filters( 'widget_title', empty($instance['title']) ? __('Upcoming Bible Lessons') : $instance['title'], $instance );
		$weeks_to_display = apply_filters( 'widget_text', empty($instance['weeks_to_display']) ? __('3') : $instance['weeks_to_display'], $instance );
		$thanksgiving_days_in_advance = apply_filters( 'widget_text', empty($instance['thanksgiving_days_in_advance']) ? __('30') : $instance['thanksgiving_days_in_advance'], $instance );
		$display_more_info_link = apply_filters( 'widget_text', empty($instance['display_more_info_link']) ? 1 : $instance['display_more_info_link'], $instance );

?>

		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('weeks_to_display'); ?>"><?php _e('Number of upcoming Bible lesson topics to display:'); ?></label>
		<input style="width: 60px;" id="<?php echo $this->get_field_id('weeks_to_display'); ?>" name="<?php echo $this->get_field_name('weeks_to_display'); ?>" type="text" value="<?php echo esc_attr($weeks_to_display); ?>" /></p>

		<p><input id="<?php echo $this->get_field_id('display_more_info_link'); ?>" name="<?php echo $this->get_field_name('display_more_info_link'); ?>" type="checkbox" <?php checked(isset($instance['display_more_info_link']) ? $instance['display_more_info_link'] : 1); ?> />&nbsp;<label for="<?php echo $this->get_field_id('display_more_info_link'); ?>"><?php _e('Display more info link'); ?></label><br />
		<a href="http://www.spirituality.com/bible-lesson/" target="_blank">More info about the Bible Lesson</a></p>

		<p style="border-top: 1px solid #eee; margin: 10px 0 8px 0; padding: 6px 0 0 0;"><strong>Special Thanksgiving day message:</strong></p>		
		<p><?php echo stp_getThanksgivingMessage(365); ?></p>

		<p><label for="<?php echo $this->get_field_id('thanksgiving_days_in_advance'); ?>"><?php _e('Days in advance to display message:<br /> (Default = 30, 0 to disable)'); ?></label>
		<input style="width: 60px;" id="<?php echo $this->get_field_id('thanksgiving_days_in_advance'); ?>" name="<?php echo $this->get_field_name('thanksgiving_days_in_advance'); ?>" type="text" value="<?php echo esc_attr($thanksgiving_days_in_advance); ?>" /></p>

<?php
	}
}


// Register widget so it displays on Widgets page
add_action( 'widgets_init', create_function('', 'return register_widget("STP_CS_Bible_Lesson_Topics");') );

?>