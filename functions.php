<?php
add_action('wp_enqueue_scripts', 'wplms_child_theme_enqueue_styles');
function wplms_child_theme_enqueue_styles()
{
	wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}


function for_B_oneEdu_single_course_enqueue_styles()
{
	wp_enqueue_style('style', get_stylesheet_uri());
	wp_enqueue_style('single', get_theme_file_uri('/assets/css/single-course.css'), false, time(), 'all');
	wp_enqueue_style('all-course', get_theme_file_uri('/assets/css/all-course.css'), false, time(), 'all');
	wp_enqueue_script('custom-script', get_theme_file_uri() . '/assets/js/custom-script.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'for_B_oneEdu_single_course_enqueue_styles');


add_action('wp_ajax_nopriv_load_posts_by_ajax', 'load_posts_by_ajax_callback');
add_action('wp_ajax_load_posts_by_ajax', 'load_posts_by_ajax_callback');

function load_posts_by_ajax_callback()
{
	check_ajax_referer('load_more_posts', 'security');
	$paged = $_POST['page'];

	$args = array(
		'post_type' => 'course',
		'posts_per_page' => 2,
		'orderby' => 'date',
		'order' => 'DESC',
		'paged' => $paged,
	);

	$my_posts = new WP_Query($args);
	if ($my_posts->have_posts()) :
		while ($my_posts->have_posts()) : $my_posts->the_post();

?>
			<div class="special-course-single">
				<div class="special-course-single-inner">
					<div class="special-course-img">
						<?php the_post_thumbnail(); ?>
					</div>

					<div class="special-course-details">
						<div class="special-course-title">
							<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						</div>
						<?php
						$course_id = get_the_ID();
						$product_id = get_post_meta($course_id, 'vibe_product', true);
						$product = wc_get_product($product_id);

						$average_rating = get_post_meta(get_the_ID(), 'average_rating', true);
						$count = get_post_meta(get_the_ID(), 'rating_count', true);
						$breakup = wplms_get_rating_breakup();
						$ratings = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0);
						foreach ($breakup as $value) {
							$ratings[$value->val] = intval($value->count);
						}

						?>

						<div class="special-course-reviews">
							<div class="custom-rating-wrapper">
								<?php
								echo '<div class="modern-star-rating">';
								if (function_exists('bp_course_display_rating')) {
									echo bp_course_display_rating($average_rating);
								} else {
									for ($i = 1; $i <= 5; $i++) {
										if ($average_rating >= 1) {
											echo '<span class="fa fa-star"></span>';
										} elseif (($average_rating < 1) && ($average_rating >= 0.3)) {
											echo '<span class="fa fa-star-half-o"></span>';
										} else {
											echo '<span class="fa fa-star-o"></span>';
										}
										$average_rating--;
									}
								} ?>
							</div>
						</div>
						<span class="sc-avg-rating"><?php echo (($average_rating) ? $average_rating : __('N.A', 'vibe')); ?></span>
						<?php
						if ($count < 1) {
							echo '<span class="sc-review-count">(No Reviews)</span>';
						} elseif ($count == 1) {
							echo '<span class="sc-review-count">(' . $count . ' ' . __('Review', 'vibe') . ')</span>';
						} else {
							echo '<span class="sc-review-count">(' . $count . ' ' . __('Reviews', 'vibe') . ')</span>';
						}
						?>
					</div>
				</div>

				<div class="special-course-price-qty">
					<div class="qty-wrapper">
						<button class="qty-minus">-</button>
						<input type="number" name="course-qty" class="course-qty" min="1" value="1" readonly>
						<button class="qty-plus">+</button>
						<a href="<?php echo site_url(); ?>/?add-to-cart=<?php echo $product_id; ?>&quantity=1" class="buy-now" data-quantity="1">Buy Now For <?php echo $product->price ? get_woocommerce_currency_symbol() . "" . $product->price : "Free"; ?></a>
					</div>

				</div>
			</div>
			</div>
			<?php
		endwhile;
	endif;
	wp_die();
}

// Course search

add_action('wp_ajax_search_courses', 'search_courses_callback');
add_action('wp_ajax_nopriv_search_courses', 'search_courses_callback');

function search_courses_callback()
{
	$search_term = $_POST['search_term'];
	$args = array(
		'post_type' => 'course',
		'post_status' => 'publish',
		's' => $search_term,
		'posts_per_page' => -1
	);
	$courses = new WP_Query($args);

	if (strlen($search_term) < 3) {
		echo "Type at least 3 or more character";
	} else {
		if ($courses->have_posts()) {
			while ($courses->have_posts()) {
				$courses->the_post();
				$search_title = get_the_title();
				$search_title = str_ireplace($search_term, '<span class="search-highlight">' . $search_term . '</span>', $search_title);
			?>
				<a href="<?php the_permalink(); ?>" target="_blank">
					<div class="search-course-wrapper">
						<div class="search-img">
							<?php the_post_thumbnail(); ?>
						</div>
						<div class="search-title">
							<h3><?php echo $search_title; ?></h3>
						</div>
					</div>
				</a>
	<?php
			}
		} else {
			echo 'No courses found';
		}
		wp_reset_postdata();
	}
	wp_die();
}



function ajax_load_scripts()
{
	?>
	<script>
		jQuery(document).ready(function($) {

			var post_count = "<?php echo ceil(wp_count_posts('course')->publish / 2); ?>";
			var page = 2;
			var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
			jQuery('#load-more').click(function() {
				jQuery('#ajax-loader').show();
				jQuery('.loader-bg').show();
				jQuery("button#load-more img").css("animation", "spin 2s linear infinite");
				jQuery('#load-more span').text('Loading...');
				var data = {
					'action': 'load_posts_by_ajax',
					'page': page,
					'security': '<?php echo wp_create_nonce("load_more_posts"); ?>'
				};

				jQuery.post(ajaxurl, data, function(response) {
					jQuery('#ajax-loader').hide();
					jQuery('.loader-bg').hide();
					jQuery("button#load-more img").css("animation", "none");
					jQuery('#load-more span').text('Load More Courses');
					jQuery('.special-courses-inner').append(response);
					if (post_count == page) {
						jQuery('#load-more').hide();
					}
					page++;
				});
			});
		});

		jQuery(document).ready(function($) {
			jQuery('#course-search-input').on('keyup', function() {
				jQuery("input.oe-course-search").css("border-bottom", "2px solid #625FFF");
				jQuery("#course-search-results").css("margin-top", "15px");
				var searchValue = $(this).val();
				if (searchValue.length >= 1) {
					jQuery.ajax({
						url: '<?php echo admin_url('admin-ajax.php'); ?>',
						type: 'post',
						data: {
							action: 'search_courses',
							search_term: searchValue
						},
						success: function(response) {
							$('#course-search-results').html(response);
						}
					});
				} else if (searchValue.length == "") {
					jQuery("input.oe-course-search").css("border-bottom", "none");
					jQuery('#course-search-results').html('');
				}

			});
		});

		jQuery(function($) {
			jQuery('#challenge-filter').change(function() {
				var filter = jQuery('#challenge-filter').val();
				$.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {
						action: 'filter_posts',
						filter: filter
					},
					success: function(response) {
						$('#filter-posts-container').html(response);
					},
					error: function(xhr, status, error) {
						console.log(error);
					}
				});
			});
		});


		jQuery(function($) {
			jQuery('#oe-course-filter').change(function() {
				var filter = jQuery('#oe-course-filter').val();
				var meta_data = jQuery('#course-order-by').val();
				var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
				jQuery.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {
						action: 'course_filter_posts',
						filter: filter,
						meta_data: meta_data,
					},
					success: function(response) {
						jQuery('#filtered-course').html(response);
					},
					error: function(xhr, status, error) {
						console.log(error);
					}
				});
			});
		});

		jQuery(function($) {
			jQuery('#course-order-by').change(function() {
				var filter = jQuery('#oe-course-filter').val();
				var orderBy = jQuery('#course-order-by').val();
				var meta_data = jQuery('#course-order-by').val();
				var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
				jQuery.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {
						action: 'course_filter_posts',
						filter: filter,
						meta_data: meta_data
					},
					success: function(response) {
						jQuery('#filtered-course').html(response);
					},
					error: function(xhr, status, error) {
						console.log(error);
					}
				});
			});
		});
		jQuery(".the-cat-list-div ul li a").each(function(index) {
			jQuery(this).on("click", function(event) {
				event.preventDefault();
				var filter = jQuery(this).attr('course-cat');
				var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
				jQuery.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {
						action: 'side_course_filter_posts',
						filter: filter
					},
					success: function(response) {
						jQuery('#filtered-course').html(response);
					},
					error: function(xhr, status, error) {
						console.log(error);
					}
				});
			});
		});
	</script>

	<?php
}

add_action('wp_footer', 'ajax_load_scripts');


// Register Case Study Post Type
function case_study_post_type()
{

	$labels = array(
		'name'                  => _x('Case Studies', 'Post Type General Name', 'vibe'),
		'singular_name'         => _x('Case Study', 'Post Type Singular Name', 'vibe'),
		'menu_name'             => __('Case Studies', 'vibe'),
		'name_admin_bar'        => __('Case Studies', 'vibe'),
		'archives'              => __('Case Study Archives', 'vibe'),
		'attributes'            => __('Case Study Attributes', 'vibe'),
		'parent_item_colon'     => __('Parent Case Study:', 'vibe'),
		'all_items'             => __('All Case Studies', 'vibe'),
		'add_new_item'          => __('Add New Case Study', 'vibe'),
		'add_new'               => __('Add New', 'vibe'),
		'new_item'              => __('New Case Study', 'vibe'),
		'edit_item'             => __('Edit Case Study', 'vibe'),
		'update_item'           => __('Update Case Study', 'vibe'),
		'view_item'             => __('View Case Study', 'vibe'),
		'view_items'            => __('View Case Studies', 'vibe'),
		'search_items'          => __('Search Case Study', 'vibe'),
		'not_found'             => __('Not found', 'vibe'),
		'not_found_in_trash'    => __('Not found in Trash', 'vibe'),
		'featured_image'        => __('Featured Image', 'vibe'),
		'set_featured_image'    => __('Set featured image', 'vibe'),
		'remove_featured_image' => __('Remove featured image', 'vibe'),
		'use_featured_image'    => __('Use as featured image', 'vibe'),
		'insert_into_item'      => __('Insert into item', 'vibe'),
		'uploaded_to_this_item' => __('Uploaded to this item', 'vibe'),
		'items_list'            => __('Items list', 'vibe'),
		'items_list_navigation' => __('Items list navigation', 'vibe'),
		'filter_items_list'     => __('Filter items list', 'vibe'),
	);
	$rewrite = array(
		'slug'                  => 'case-studies',
		'with_front'            => true,
		'pages'                 => true,
		'feeds'                 => true,
	);
	$args = array(
		'label'                 => __('Case Study', 'vibe'),
		'description'           => __('Case Study For OE', 'vibe'),
		'labels'                => $labels,
		'supports'              => array('title', 'editor', 'thumbnail'),
		'taxonomies'            => array('challenge'),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-layout',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'post',
	);
	register_post_type('case_study', $args);
}
add_action('init', 'case_study_post_type', 0);

// Register Challenge Taxonomy
function challenge_taxonomy()
{

	$labels = array(
		'name'                       => _x('Challenges', 'Taxonomy General Name', 'vibe'),
		'singular_name'              => _x('Challenge', 'Taxonomy Singular Name', 'vibe'),
		'menu_name'                  => __('Challenge', 'vibe'),
		'all_items'                  => __('Challenges', 'vibe'),
		'parent_item'                => __('Parent Challenge', 'vibe'),
		'parent_item_colon'          => __('Parent Challenge:', 'vibe'),
		'new_item_name'              => __('New Challenge Name', 'vibe'),
		'add_new_item'               => __('Add New Challenge', 'vibe'),
		'edit_item'                  => __('Edit Challenge', 'vibe'),
		'update_item'                => __('Update Challenge', 'vibe'),
		'view_item'                  => __('View Challenge', 'vibe'),
		'separate_items_with_commas' => __('Separate items with commas', 'vibe'),
		'add_or_remove_items'        => __('Add or remove items', 'vibe'),
		'choose_from_most_used'      => __('Choose from the most used', 'vibe'),
		'popular_items'              => __('Popular Items', 'vibe'),
		'search_items'               => __('Search Items', 'vibe'),
		'not_found'                  => __('Not Found', 'vibe'),
		'no_terms'                   => __('No items', 'vibe'),
		'items_list'                 => __('Items list', 'vibe'),
		'items_list_navigation'      => __('Items list navigation', 'vibe'),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy('challenge', array('case_study'), $args);
}
add_action('init', 'challenge_taxonomy', 0);


function filter_posts_callback()
{
	$filter = $_POST['filter'];
	if ($filter == 'all') {
		$args = array(
			'post_type' => 'case_study',
			'posts_per_page' => -1,
		);
	} else {
		$args = array(
			'post_type' => 'case_study',
			'posts_per_page' => -1,
			'tax_query' => array(
				array(
					'taxonomy' => 'challenge',
					'field' => 'slug',
					'terms' => $filter
				)
			)
		);
	}

	$query = new WP_Query($args);
	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();
	?>
			<div class="filter-post-single">
				<div class="filter-post-single-inner">
					<?php the_post_thumbnail(); ?>
					<h3><?php the_title(); ?></h3>
					<div class="case-desc">
						<?php the_excerpt(); ?>
					</div>
				</div>
			</div>
		<?php
		}
		wp_reset_postdata();
	} else {
		echo 'No posts found';
	}
	die();
}
add_action('wp_ajax_filter_posts', 'filter_posts_callback');
add_action('wp_ajax_nopriv_filter_posts', 'filter_posts_callback');

function course_filter_posts()
{
	$filter = $_POST['filter'];
	$meta_data = $_POST['meta_data'];
	$main_args = array(
		'post_type' => 'course',
		'posts_per_page' => -1,
	);

	if ($filter == 'all_cat') {
		$args_1 = array(
			'orderby' => 'date',
			'order' => 'ASC'
		);
	} else {
		$args_1 = array(
			'tax_query' => array(
				array(
					'taxonomy' => 'course-cat',
					'field' => 'slug',
					'terms' => $filter
				)
			),
			'orderby' => 'date',
			'order' => 'ASC'
		);
	}

	if ($meta_data == 'all_sort') {

		$args_2 = array(
			'orderby'   => 'date',
			'order' => 'ASC'
		);
	} elseif ($meta_data == 'newest') {

		$args_2 = array(
			'orderby'   => 'date',
			'order' => 'DESC'
		);
	} elseif ($meta_data == 'alphabetical') {

		$args_2 = array(
			'orderby'   => 'title',
			'order' => 'ASC'
		);
	} elseif ($meta_data == 'popular') {

		$args_2 = array(
			'orderby'   => 'meta_value_num',
			'meta_query' => array(
				array(
					'key' => 'vibe_students',
				),
			),
			'order' => 'DESC'
		);
	} elseif ($meta_data == 'rated') {

		$args_2 = array(
			'orderby'   => 'meta_value_num',
			'meta_query' => array(
				array(
					'key' => 'average_rating',
				),
			),
			'order' => 'DESC'
		);
	}
	$args = array_merge($main_args, $args_1, $args_2);
	$query = new WP_Query($args);
	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();
		?>
			<li>
				<div class="filter-post-single-course">
					<div class="filter-post-single-inner-course">
						<div class="for-b-o-course-img">
							<?php bp_course_avatar(); ?>
						</div>

						<div class="for-bo-course-title">
							<h3><?php the_title(); ?></h3>
						</div>
						<div class="all-course-course-price-qty">
							<div class="qty-wrapper">
								<button class="qty-minus">-</button>
								<input type="number" name="course-qty" class="course-qty" min="10" value="10" readonly>
								<button class="qty-plus">+</button>
								<div class="for-b-o-course-price-btn">
									<div class="course-btn-div">
										<?php
										$currency_symble = get_woocommerce_currency_symbol();
										$price = get_post_meta($product_id, '_regular_price', true);
										$sale = get_post_meta($product_id, '_sale_price', true);

										if (!bp_is_my_profile()) {

											if (!empty($sale)) {
										?>
												<div class="offer-bg">
													<strong>
														<ins><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol"><?php echo $currency_symble; ?></span><?php echo $sale; ?></span></ins>
														<del><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol"><?php echo $currency_symble; ?></span><?php echo $price; ?></span></del>
													</strong>
												</div>
											<?php
											} elseif (empty($sale) && !empty($price)) {
											?>
												<div class="offer-bg">
													<strong>
														<ins><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol"><?php echo $currency_symble; ?></span><?php echo $price; ?></span></ins>
													</strong>
												</div>
											<?php
											} elseif (empty($sale) && empty($price)) {
											?>
												<div class="offer-bg">
													<strong>
														<ins><span class="woocommerce-Price-amount amount">free</span></ins>
													</strong>
												</div>
											<?php
											}
											?>
											<div class="the-add-to-btns-flex">
												<a class="view-details" href="<?php echo get_site_url();  ?>/cart/?add-to-cart=<?php echo $product_id; ?>&quantity=10" class="buy-now" data-quantity="1">
													Add to Cart</a>
											</div>
										<?php

										} else {
											the_course_button(get_the_ID());
										}

										?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</li>
		<?php
		}
		wp_reset_postdata();
	} else {
		echo 'No posts found';
	}
	die();
}
add_action('wp_ajax_course_filter_posts', 'course_filter_posts');
add_action('wp_ajax_nopriv_course_filter_posts', 'course_filter_posts');


function side_course_filter_posts()
{
	$filter = $_POST['filter'];
	if ($filter == 'all') {
		$args = array(
			'post_type' => 'course',
			'posts_per_page' => -1,
		);
	} else {
		$args = array(
			'post_type' => 'course',
			'posts_per_page' => -1,
			'tax_query' => array(
				array(
					'taxonomy' => 'course-cat',
					'field' => 'slug',
					'terms' => $filter
				)
			)
		);
	}
	$query = new WP_Query($args);
	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();
		?>
			<li>
				<div class="filter-post-single-course">
					<div class="filter-post-single-inner-course">
						<div class="for-b-o-course-img">
							<?php bp_course_avatar(); ?>
						</div>

						<div class="for-bo-course-title">
							<h3><?php the_title(); ?></h3>
						</div>
						<div class="all-course-course-price-qty">
							<div class="qty-wrapper">
								<button class="qty-minus">-</button>
								<input type="number" name="course-qty" class="course-qty" min="10" value="10" readonly>
								<button class="qty-plus">+</button>
								<div class="for-b-o-course-price-btn">
									<div class="course-btn-div">
										<?php
										$currency_symble = get_woocommerce_currency_symbol();
										$price = get_post_meta($product_id, '_regular_price', true);
										$sale = get_post_meta($product_id, '_sale_price', true);

										if (!bp_is_my_profile()) {

											if (!empty($sale)) {
										?>
												<div class="offer-bg">
													<strong>
														<ins><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol"><?php echo $currency_symble; ?></span><?php echo $sale; ?></span></ins>
														<del><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol"><?php echo $currency_symble; ?></span><?php echo $price; ?></span></del>
													</strong>
												</div>
											<?php
											} elseif (empty($sale) && !empty($price)) {
											?>
												<div class="offer-bg">
													<strong>
														<ins><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol"><?php echo $currency_symble; ?></span><?php echo $price; ?></span></ins>
													</strong>
												</div>
											<?php
											} elseif (empty($sale) && empty($price)) {
											?>
												<div class="offer-bg">
													<strong>
														<ins><span class="woocommerce-Price-amount amount">free</span></ins>
													</strong>
												</div>
											<?php
											}
											?>
											<div class="the-add-to-btns-flex">
												<a class="view-details" href="<?php echo get_site_url();  ?>/cart/?add-to-cart=<?php echo $product_id; ?>&quantity=10" class="buy-now" data-quantity="1">
													Add to Cart</a>
											</div>
										<?php

										} else {
											the_course_button(get_the_ID());
										}

										?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</li>
<?php
		}
		wp_reset_postdata();
	} else {
		echo 'No posts found';
	}
	die();
}
add_action('wp_ajax_side_course_filter_posts', 'side_course_filter_posts');
add_action('wp_ajax_nopriv_side_course_filter_posts', 'side_course_filter_posts');
