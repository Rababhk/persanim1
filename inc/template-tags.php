<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package coolte
 */

if ( ! function_exists( 'coolte_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function coolte_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'coolte' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'coolte_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function coolte_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'coolte' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'coolte_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function coolte_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'coolte' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'coolte' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'coolte' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'coolte' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'coolte' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'coolte' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'coolte_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function coolte_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( 'post-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
			?>
		</a>

		<?php
		endif; // End is_singular().
	}
endif;




if (!function_exists('coolte_post_date')) :
    function coolte_post_date()
    {
        // Hide category and tag text for pages.
        if ('post' === get_post_type()) { ?>

        	    <span class="twp-posts-date">
					<i class="fa fa-clock-o"></i>
					<span>
						<?php
						$site_date_layout_option = esc_attr(coolte_get_option('site_date_layout_option'));
						if ($site_date_layout_option == 'normal-format') {
							the_time(get_option('date_format'));
						} else {
							echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ' . __('ago', 'coolte');
						}

						?>
					</span>
				</span>
            <?php }
    }
endif;



if (!function_exists('coolte_post_author')) :

    function coolte_post_author()
    {
        global $post;
        if ('post' == get_post_type($post->ID)):
            $author_id = $post->post_author;
            ?>

            <span class="twp-author">
				<a href="<?php echo esc_url(get_author_posts_url($author_id)) ?>">
					<span class="twp-icon"><i class="fa fa-user"></i></span>
	                <span class="twp-caption"><?php echo esc_html__( 'By ', 'coolte'); ?><?php echo esc_html(get_the_author_meta('display_name', $author_id)); ?></span>
	            </a>
        	</span>
        <?php
        endif;

    }
endif;

if (!function_exists('coolte_post_categories')) :
    function coolte_post_categories($separator = '&nbsp')
    {


        // Hide category and tag text for pages.
        if ('post' === get_post_type()) {

            global $post;
			
            $post_categories = get_the_category($post->ID);
            if ($post_categories) {
                $output = '<ul class="twp-category twp-secondary-font">';
                foreach ($post_categories as $post_category) {
                    $output .= '<li>
                             <a  class="twp-secondary-anchor-text" href="' . esc_url(get_category_link($post_category)) . '" alt="' . esc_attr(sprintf(__('View all posts in %s', 'coolte'), $post_category->name)) . '"> 
                                 ' . esc_html($post_category->name) . '
                             </a>
                        </li>';
                }
                $output .= '</ul>';
                echo $output;

            }
        }
    }
endif;


if (!function_exists('coolte_get_comments_count')) :
	/**
	 * @param $post_id
	 */
	function coolte_get_comments_count($post_id)
	{ 
	    //$show_comment_count = coolte_get_option('global_show_comment_count');
	    $show_comment_count = 1;
	    if ($show_comment_count == 1):

	        $comment_count = get_comments_number($post_id);
	        if (absint($comment_count) >= 1):
	        ?>
	        <span class="twp-post-comment">
				<i class="fa fa-comment"></i>
				<a href="<?php the_permalink(); ?>">
					<?php echo get_comments_number($post_id); ?>
				</a>
	        </span>
	    <?php endif;
	    endif;

	}
endif;

/**
 * Returns no post icons.
 *
 * @since  coolte 1.0.0
 */
if (!function_exists('coolte_post_format')):
    function coolte_post_format($post_id)
    {
        $post_format = get_post_format($post_id);
        switch ($post_format) {
            case "image":
                $post_format = "<span class='twp-post-format-icon'><i class='fa fa-camera'></i></span>";
                break;
            case "video":
                $post_format = "<span class='twp-post-format-icon'><i class='fa fa-play'></i></span>";
                break;
            case "gallery":
                $post_format = "<span class='twp-post-format-icon'><i class='fa fa-image'></i></span>";
                break;
            case "quote":
                $post_format = "<span class='twp-post-format-icon'><i class='fa fa-quote-left'></i></span>";
                break; 
           case "audio":
                $post_format = "<span class='twp-post-format-icon'><i class='fa fa-volume-up'></i></span>";
                break;
            default:
                $post_format = "";
        }

        echo $post_format;
    }

endif;