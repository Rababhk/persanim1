<?php
/**
 * Template part for displaying posts	
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package coolte
 */
?>
<article id="post-<?php the_ID(); ?>" class="twp-single-page-post-section" >
	<div class="twp-single-page-author-section">
		<div class="twp-row">
			<?php if (1 == coolte_get_option('enable_authro_detail_single_page')) { ?>
				<?php $author_id = $post->post_author; ?>
				<div class="twp-single-post-author">
					<a class="d-block" href="<?php echo esc_url(get_author_posts_url($author_id)) ?>">
						<span class="twp-author-image"><img src="<?php echo esc_url(get_avatar_url($author_id, array('size' => 150))); ?>"></span>
						<span class="twp-caption twp-meta-font"><?php echo esc_html(get_the_author_meta('display_name', $author_id)); ?></span>
					</a>
				</div>
			<?php } ?>
			<header class="entry-header">
				<?php coolte_post_categories(); ?>
				<h2 class="entry-title">
					<?php echo esc_attr(coolte_post_format(get_the_ID())); ?>
					<a href="<?php echo esc_url( get_permalink() );?>" rel="bookmark">
					<?php the_title(); ?>
					</a>
				</h2>
					<div class="twp-author-meta">
						<?php coolte_post_date(); ?>
						<?php coolte_get_comments_count(get_the_ID()); ?>
					</div>

			</header><!-- .entry-header -->
			
		</div>
		<?php if (1 == coolte_get_option('enable_except_on_single_post')) {
				if (has_excerpt()){ ?>
					<div class="single-content-experpt">
						<?php the_excerpt(); ?>
					</div>
				<?php }
			}
			?>
	</div>

	<?php 
	$post_options = get_post_meta( $post->ID, 'coolte-meta-checkbox', true );
	if (!empty( $post_options ) ) {
	   coolte_post_thumbnail();
	} ?>

	<div class="entry-content">
		<?php
		the_content( sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'coolte' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		) );
		?>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
