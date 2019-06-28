<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package kanso-general
 */

if ( ! function_exists( 'kanso_general_posted_date' ) ) :
	function kanso_general_posted_date() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);

		echo $time_string;
	}

endif;

if ( ! function_exists( 'kanso_general_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function kanso_general_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">created at %2$s</time><br><time class="updated" datetime="%3$s">updated at %4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( '%s', 'post date', 'kanso-general' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'kanso-general' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span><br><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'kanso_general_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function kanso_general_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'kanso-general' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'kanso-general' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'kanso-general' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'kanso-general' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		// if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		// echo '<span class="comments-link">';
		// comments_popup_link(
		// sprintf(
		// wp_kses(
		// * translators: %s: post title */
		// __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'kanso-general' ),
		// array(
		// 'span' => array(
		// 'class' => array(),
		// ),
		// )
		// ),
		// get_the_title()
		// )
		// );
		// echo '</span>';
		// }
		// edit_post_link(
		// sprintf(
		// wp_kses(
		// * translators: %s: Name of current post. Only visible to screen readers */
		// __( 'Edit <span class="screen-reader-text">%s</span>', 'kanso-general' ),
		// array(
		// 'span' => array(
		// 'class' => array(),
		// ),
		// )
		// ),
		// get_the_title()
		// ),
		// '<span class="edit-link">',
		// '</span>'
		// );
	}
endif;

if ( ! function_exists( 'kanso_general_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function kanso_general_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

	<figure class="wp-block-image alignwide">
			<?php the_post_thumbnail(); ?>
	</figure><!-- .post-thumbnail -->

	<?php else : ?>

	<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
		<?php
			the_post_thumbnail(
				'post-thumbnail',
				array(
					'alt'   => the_title_attribute(
						array(
							'echo' => false,
						)
					),
					'class' => 'uk-position-center',
				)
			);
		?>
	</a>

		<?php
	endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'kanso_general_get_thumnail_url' ) ) :
	function kanso_general_get_thumnail_url() {
		$post_id = get_the_ID();
		$img_url = get_the_post_thumbnail_url( $post_id, 'full' );
		if ( $img_url == '' ) {
			$img_url = get_template_directory_uri() . '/images/thumnails/' . ( $post_id % 5 + 1 ) . '.png';
		}

		return $img_url;
	}
endif;

if ( ! function_exists( 'kanso_get_blog_home_url' ) ) :
	function kanso_get_blog_home_url() {
		if ( get_option( 'show_on_front' ) == 'page' ) {
			return get_permalink( get_option( 'page_for_posts' ) );
		} else {
			return get_home_url();
		}
	}
endif;

if ( ! function_exists( 'kanso_get_post_navigation' ) ) :
	function kanso_get_post_navigation() {
		$pagination = get_the_posts_pagination(
			array(
				'type'      => 'list',
				'prev_text' => '<span uk-pagination-previous></span></a>',
				'next_text' => '<span uk-pagination-next></span></a>',
				'mid_size'  => 3,
			)
		);
		$pagination = str_replace(
			array( "<ul class='page-numbers'>", 'class="page-numbers current"' ),
			array( "<ul class='uk-pagination uk-margin-medium-top uk-text-center'>", 'class="uk-active"' ),
			$pagination
		);

		return $pagination;
	}
endif;

if ( ! function_exists( 'kanso_the_card_style' ) ) :
	function kanso_the_card_style() {
		echo 'style="height:200px;"';
	}
endif;

if ( ! function_exists( 'kanso_get_post_label' ) ) :
	function kanso_get_post_label() {
		return esc_html( get_post_type_object( get_post_type() )->label );
	}
endif;


if ( ! function_exists( 'kanso_general_no_content' ) ) :
	function kanso_general_no_content( $content ) {
		if ( is_page() ) {
			$can_edit = false;
			if( is_user_logged_in() ) {
				if (current_user_can('edit_posts')) {
					$can_edit = true;
				}
			}

			if( $can_edit || ( '' !== trim( $content ) ) ) {
				return $content;
			} else {
				return '<div uk-alert class="uk-alert-none uk-margin-large-top"><h3><span uk-icon="icon: info"></span> お知らせ</h3>
<p>このページは作成中です。今しばらくお待ちください。</p>
</div>';
			}
		}

		return $content;
	}
endif;
add_filter( 'the_content', 'kanso_general_no_content' );