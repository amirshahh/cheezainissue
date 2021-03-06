<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if( oritina_get_config( 'product-related' ) == '1' ) :
	
	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly
	}

	global $product, $woocommerce_loop;

	if ( empty( $product ) || ! $product->exists() ) {
		return;
	}

	$related =  wc_get_related_products( $product->get_id() );

	if ( sizeof( $related ) === 0 ) return;

	$args = apply_filters( 'woocommerce_related_products_args', array(
		'post_type'            => 'product',
		'ignore_sticky_posts'  => 1,
		'no_found_rows'        => 1,
		'posts_per_page'       => (int)oritina_get_config( 'product-related-count' ),
		'orderby'              => $orderby,
		'post__in'             => $related,
		'post__not_in'         => array( $product->get_id() )
	) );

	$products = new WP_Query( $args );

	$woocommerce_loop['columns'] = 1;

	if ( $products->have_posts() ) : ?>

		<div class="related">
			<div class="title-block"><h2><?php esc_html_e( 'Related Products', 'oritina' ); ?></h2></div>

			<div class="products-list grid slick-carousel" data-nav="true" data-columns4="1" data-columns3="2" data-columns2="2" data-columns1="<?php echo esc_attr((int)oritina_get_config( 'product-related-cols',3 )); ?>" data-columns="<?php echo esc_attr((int)oritina_get_config( 'product-related-cols',3 )); ?>">

				<?php while ( $products->have_posts() ) : $products->the_post(); ?>
				<div class="products-entry clearfix product-wapper">
				<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
					<div class="products-thumb">
						<?php
							/**
							 * woocommerce_before_shop_loop_item_title hook
							 *
							 * @hooked woocommerce_show_product_loop_sale_flash - 10
							 * @hooked woocommerce_template_loop_product_thumbnail - 10
							 */
							do_action( 'woocommerce_before_shop_loop_item_title' );
							
						?>
					</div>
					<div class="products-content">
						<div class='product-button'>
							<?php do_action('woocommerce_after_shop_loop_item'); ?>
						</div>
						<div class="products-content-left">
							<h3 class="product-title"><a href="<?php esc_url(the_permalink()); ?>"><?php esc_html(the_title()); ?></a></h3>
							<?php woocommerce_template_loop_price(); ?>
						</div>
						<div class="products-content-right">
							<?php remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price'); ?>
							<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
							<div class="product-review-count">
								<?php echo esc_attr($product->get_review_count())." ".esc_html__("reviews","oritina"); ?>
							</div>
						</div>
					</div>
				</div>
				<?php endwhile; // end of the loop. ?>

			</div>
		</div>
	<?php endif;

	wp_reset_postdata();

endif;
