<?php

/**
 * The template for displaying Course font
 *
 * Override this template by copying it to yourtheme/course/single/front.php
 *
 * @author 		VibeThemes
 * @package 	vibe-course-module/templates
 * @version     2.0
 */

global $post;
$id = get_the_ID();

do_action('wplms_course_before_front_main');


do_action('wplms_before_course_description');

?>
<?php
if (!defined('ABSPATH')) exit;
?>
<div class="for-bus-one-avatar">
	<div id="item-header-avatar">
		<?php bp_course_avatar(); ?>
	</div>
</div>

<div class="the-Tab-functional">
	<ul class="nav nav-tabs">
		<li class="active"><a data-toggle="tab" href="#menu0">Overview</a></li>
		<li><a data-toggle="tab" href="#menu1">Curriculum</a></li>
		<li><a data-toggle="tab" href="#menu2">Instructor</a></li>
		<li><a data-toggle="tab" href="#menu3">Review</a></li>
	</ul>

	<div class="tab-content">
		<div id="menu0" class="tab-pane fade in active">
			<?php
			the_content();
			?>
		</div>
		<div id="menu1" class="tab-pane fade">
			<?php
			do_action('wplms_after_course_description');
			?>
		</div>
		<div id="menu2" class="tab-pane fade">
			<?php
			$enable_instructor = apply_filters('wplms_display_instructor', true, get_the_ID());
			if ($enable_instructor) {
			?>
				<div id="item-admins">
					<h3><?php _e('Instructors', 'vibe'); ?></h3>
					<?php
					bp_course_instructor();

					do_action('bp_after_course_menu_instructors');
					?>
				</div><!-- #item-actions -->
			<?php
			}
			?>
		</div>
		<div id="menu3" class="tab-pane fade">
			<div class="course_reviews" id="course-reviews">
				<?php
				comments_template('/course-review.php', true);
				?>
			</div>
		</div>
	</div>

</div>