<?php

/**
 * The template for displaying Course Header
 *
 * Override this template by copying it to yourtheme/course/single/header.php
 *
 * @author 		VibeThemes
 * @package 	vibe-course-module/templates
 * @version     2.0
 */
if (!defined('ABSPATH')) exit;
do_action('bp_before_course_header');

?>
<div class="col-md-12 col-sm-12">
	<div id="item-header-content">
		<div class="bb-for-bred">
			<?php vibe_breadcrumbs(); ?>
		</div>
		<div class="bb-for-T">
			<h1><?php bp_course_name(); ?></h1>
		</div>
	</div><!-- #item-header-content -->
</div>
<?php
do_action('bp_after_course_header');
?>