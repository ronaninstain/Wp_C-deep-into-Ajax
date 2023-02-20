<?php
if (!defined('ABSPATH')) exit;
$id = vibe_get_bp_page_id('course');
?>
<section id="title" class="for-b-oe-all-title">
	<?php do_action('wplms_before_title'); ?>
	<div class="<?php echo vibe_get_container(); ?>">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="bb-for-bred-all">
					<?php vibe_breadcrumbs(); ?>
				</div>
				<div class="pagetitle">
					<?php
					if (is_tax()) {
						echo '<h1>';
						single_cat_title();
						echo '</h1>';
						echo do_shortcode(category_description());
					} else {
						echo '<h1>' . vibe_get_title($id) . '</h1>';
						the_sub_title($id);
					}
					?>
				</div>
				<div class="dir-search" role="search">
					<?php bp_directory_course_search_form(); ?>
				</div><!-- #group-dir-search -->
			</div>
		</div>
	</div>
</section>
<section class="the-selection-sec-oe-ness-all">
	<div class="for-flexing-1st-ness-oe">
		<div class="the-titile-pointing-out-availabl-courses">
			<h4>We found <span>7000+</span> courses available for you</h4>
		</div>
		<div class="item-list-tabs" id="subnav" role="navigation">
			<ul>
				<li id="course-order-select" class="last filter">

					<label for="course-order-by">Order By</label>
					<select id="course-order-by">
						<option value="all_sort">All</option>
						<option value="newest">Newest</option>
						<option value="alphabetical">Alphabetical</option>
						<option value="popular">Popular</option>
						<option value="rated">Rated</option>
					</select>
				</li>
				<li id="course-categories-select" class="last filter">
					<label for="course-category">Categories</label>
					<?php
					$args = array(
						'taxonomy' => 'course-cat',
						'hide_empty' => false,
						'posts_per_page' => -1
					);
					?>
					<form id="filter-posts">
						<select name="challenge-filter" id="oe-course-filter">
							<option value="all_cat">All</option>
							<?php
							$terms = get_terms('course-cat');
							foreach ($terms as $term) {
								echo '<option value="' . $term->slug . '">' . $term->name . '</option>';
							}
							?>
						</select>
					</form>
				</li>

				<li class="switch_view">
					<div class="grid_list_wrapper">
						<a id="grid_view"><i class="fa fa-th-large" aria-hidden="true"></i></a>
						<a id="list_view" class="active"><i class="fa fa-list" aria-hidden="true"></i></a>
					</div>
				</li>
			</ul>
		</div>
	</div>
</section>
<section id="content">
	<div id="buddypress">
		<div class="<?php echo vibe_get_container(); ?>">

			<?php do_action('bp_before_directory_course_page'); ?>

			<div class="padder">

				<?php do_action('bp_before_directory_course'); ?>
				<div class="row for-order-change-boe">
					<div class="col-md-3 col-sm-12 col-xs-12 bo-side-control">
						<div class="for-all-business-oe-sidebar">
							<div class="the-enquiry-form-div">
								<div class="the-actual-div-enq">
									<div class="the-img-div"><img src="<?php echo get_theme_file_uri() . '/assets/img/eq.png'; ?>" alt="img" /></div>
									<div class="the-en-btn-div"><a href="#">Sales Enquiry</a></div>
								</div>
							</div>
							<div class="the-b-oe-cat-list">
								<div class="the-cat-title-div">
									<h2>Category</h2>
								</div>
								<div class="the-cat-list-div">
									<?php
									$args = array(
										'taxonomy' => 'course-cat',
										'hide_empty' => false
									);
									$categories = get_terms($args);
									if (!empty($categories)) {
										echo '<ul>';
										foreach ($categories as $category) {
											// $count = $category->count;
											$category_link = get_term_link($category);
											echo '<li>' . '<a href="' . esc_url($category_link) . '" course-cat="' . $category->slug . '">' . $category->name . '<i class="fa fa-chevron-right" aria-hidden="true"></i> </a>
											' . '</li>';
										}
										echo '</ul>';
									}
									?>
								</div>
							</div>
							<?php
							$sidebar = apply_filters('wplms_sidebar', 'buddypress', $id);
							if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($sidebar)) : ?>
							<?php endif; ?>
						</div>
					</div>

					<div class="col-md-9 col-sm-12 col-xs-12 bo-content-control">
						<ul id="filtered-course">
							<?php
							$args = array(
								'post_type' => 'course',
								'posts_per_page' => -1,
							);
							$query = new WP_Query($args);
							if ($query->have_posts()) {
								while ($query->have_posts()) {
									$query->the_post();
							?>
									<li>
										<?php $product_id = get_post_meta(get_the_ID(), 'vibe_product', true); ?>
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
							?>
						</ul>
					</div>


				</div>
				<?php do_action('bp_after_directory_course'); ?>

			</div><!-- .padder -->

			<?php do_action('bp_after_directory_course_page'); ?>
		</div><!-- #content -->
	</div>
</section>

<script>
	jQuery(document).on('click', '.qty-plus', function() {
		var qtyVal = parseInt(jQuery(this).prev().val());
		jQuery(this).prev().val(qtyVal += 1);

		//get qty value
		var qtyVal = jQuery(this).prev().val();
		//get url
		var getUrl = jQuery('.view-details').attr('href');
		var url = new URL(getUrl);
		var search_params = url.searchParams;
		search_params.set('quantity', qtyVal);

		url.search = search_params.toString();

		var new_url = url.toString();
		jQuery('.view-details').attr('href', new_url);
		jQuery('.view-details').attr('data-quantity', qtyVal);
	});

	jQuery(document).on('click', '.qty-minus', function() {
		var qtyVal = parseInt(jQuery(this).next().val(), 10);
		if (qtyVal == 10) {
			return;
		} else {
			jQuery(this).next().val(qtyVal -= 1);
		}

		//get qty value
		var qtyVal = jQuery(this).next().val();
		//get url
		var getUrl = jQuery('.view-details').attr('href');
		var url = new URL(getUrl);
		var search_params = url.searchParams;
		search_params.set('quantity', qtyVal);

		url.search = search_params.toString();

		var new_url = url.toString();
		jQuery('.view-details').attr('href', new_url);
		jQuery('.view-details').attr('data-quantity', qtyVal);
	});
</script>