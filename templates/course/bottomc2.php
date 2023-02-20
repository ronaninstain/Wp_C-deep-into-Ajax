<?php
if (!defined('ABSPATH')) exit;
do_action('wplms_single_course_content_end');
?>
</div>
<div class="col-md-4 col-sm-4 sidebar-col">
	<div class="the-course-price-div">
		<h5>Grab This Course For</h5>
		<?php

		$product_id = get_post_meta(get_the_ID(), 'vibe_product', true);

		$currency_symble = get_woocommerce_currency_symbol();
		$price = get_post_meta($product_id, '_regular_price', true);
		$sale = get_post_meta($product_id, '_sale_price', true);

		if (!bp_is_my_profile()) {

			if (!empty($sale)) {
		?>
				<div class="offer-bg">
					<strong>
						<del><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol"><?php echo $currency_symble; ?></span><?php echo $price; ?></span></del>
						<ins><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol"><?php echo $currency_symble; ?></span><?php echo $sale; ?></span></ins>
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
		<?php

		} else {
			the_course_button(get_the_ID());
		}

		?>
	</div>
	<div class="single-course-price-qty">
		<div class="qty-wrapper">
			<button class="qty-minus">-</button>
			<input type="number" name="course-qty" class="course-qty" min="10" value="10" readonly>
			<button class="qty-plus">+</button>
			<div class="the-add-to-btns-flex">
				<a class="view-details" href="<?php echo get_site_url();  ?>/cart/?add-to-cart=<?php echo $product_id; ?>&quantity=10" class="buy-now" data-quantity="1"><i class="fa fa-shopping-cart" aria-hidden="true"></i>
					Buy Now</a>
			</div>
		</div>
	</div>
	<script>
		jQuery(document).on('click', '.qty-plus', function() {
			var qtyVal = parseInt(jQuery(this).prev().val(), 10);
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
	<div class="for-course-offers-for-b-oe">
		<h4>40% Discount for orders of
			</br>10+ Courses</h4>
		<h4>50% Discount for orders of
			</br>50+ Courses</h4>
		<h4>60% Discount for orders of
			</br>100+ Courses</h4>

		<a href="#">View All Plans</a>
	</div>

	<div class="the-enquiry-form-div">
		<div class="the-actual-div-enq">
			<div class="the-img-div"><img src="<?php echo get_theme_file_uri() . '/assets/img/eq.png'; ?>" alt="img" /></div>
			<div class="the-en-btn-div"><a href="#">Sales Enquiry</a></div>
		</div>
	</div>
	<?php
	$sidebar = apply_filters('wplms_sidebar', 'coursesidebar', get_the_ID());
	if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($sidebar)) : ?>
	<?php endif; ?>
</div>
</div><!-- .row -->
</div><!-- .container -->
</div><!-- #buddypress -->
</section>