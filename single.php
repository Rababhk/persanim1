<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package coolte
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'single' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
			$next_post = get_next_post();
			if (!empty( $next_post )): ?>
				<div class="twp-single-next-post">
					<h3 class="twp-pagination-title">
						<a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>">
							<?php echo esc_html__('Next Post','coolte'); ?><i class="fa fa-chevron-right"></i>
						</a>
					</h3>

					<?php
						$post_categories = get_the_category($next_post);
						if ($post_categories) {
							$output = '<ul class="twp-category twp-secondary-font">';
							foreach ($post_categories as $post_category) {
								$output .= '<li>
										<a class="twp-secondary-anchor-text" href="' . esc_url(get_category_link($post_category)) . '" alt="' . esc_attr(sprintf(__('View all posts in %s', 'coolte'), $post_category->name)) . '"> 
											' . esc_html($post_category->name) . '
										</a>
									</li>';
							}
							$output .= '</ul>';
							echo $output;
			
						}
					?>
					
					<h2><a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>"><?php echo esc_html( $next_post->post_title ); ?></a></h2>

					<div class="twp-author-meta twp-meta-font">
						<span class="twp-posts-date"><i class="fa fa-clock-o"></i><span><?php echo get_the_date('D M j , Y', $next_post->ID  ); ?></span></span>
					</div>
						
					<div class="twp-caption"><?php echo esc_html( get_the_excerpt( $next_post->ID ) ); ?></div>
					<?php 
					if (!empty(get_the_post_thumbnail( $next_post->ID , 'large' ))) { ?>
						<div class="twp-image-section"><?php echo wp_kses_post(get_the_post_thumbnail( $next_post->ID , 'large' )); ?></div>
					<?php } ?>
				</div>
			<?php endif;
		endwhile; // End of the loop.
		?>
			<?php do_action('coolte_action_related_post'); ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
