<?php
/**
 * Arhive content.
 *
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

global $post;

$config = Presscore_Config::get_instance();

$media_items = get_post_meta( $post->ID, '_dt_album_media_items', true );
$exclude_cover = get_post_meta( $post->ID, '_dt_album_options_exclude_featured_image', true );

// if we have post thumbnail and it's not hidden
if ( has_post_thumbnail() ) {
	array_unshift( $media_items, get_post_thumbnail_id() );
}

$attachments_data = presscore_get_attachment_post_data( $media_items );

// if there are one image in gallery
if ( count($attachments_data) == 1 ) {
	$class[] = 'rollover-zoom';
	$exclude_cover = false;
}
$style = ' style="width: 270px;"';
$rell = 'data-pp="prettyPhoto[album-' . $post->ID . ']"';
?>

<?php do_action('presscore_before_post'); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>

	<?php
	if ( !post_password_required() && $attachments_data ) {

		$title_image = array_shift($attachments_data);
		$share_buttons = presscore_get_share_buttons_for_prettyphoto( 'photo', array( 'id' => $title_image['ID'] ) );
		$title_args = array(
			'img_meta' 	=> array( $title_image['full'], $title_image['width'], $title_image['height'] ),
			'img_id'	=> $title_image['ID'],
			'class'		=> 'link show-content alignleft rollover',
			'custom'	=> $rell . ' ' . $share_buttons . ' ' . $style,
			'echo'		=> false,
			'wrap'		=> '<a %HREF% %CLASS% %CUSTOM% %TITLE%><img %IMG_CLASS% %SRC% %IMG_TITLE% %ALT% %SIZE% /></a>',
		);

		$media = dt_get_thumb_img( $title_args );

		if ( has_post_thumbnail() && $exclude_cover ) {
			unset( $attachments_data[0] );
		}

		$hidden_gallery = '';
		foreach ( $attachments_data as $att ) {

			$share_buttons = presscore_get_share_buttons_for_prettyphoto( 'photo', array( 'id' => $att['ID'] ) );
			$att_args = array(
				'img_meta'	=> $att['thumbnail'],
				'img_id'	=> $att['ID'],
				'href'		=> $att['full'],
				'custom'	=> $rell . ' ' . $share_buttons,
			);

			if ( !empty($att['video_url']) ) {
				$att_args['href'] = $att['video_url'];
			}

			$hidden_gallery .= dt_get_thumb_img( array_merge( $title_args, $att_args ) );
		}

		if ( $hidden_gallery ) {
			$hidden_gallery = '<div class="dt-prettyphoto-gallery-container" style="display: none;">' . $hidden_gallery . '</div>';
		}

		$media .= $hidden_gallery;

		echo '<div class="blog-media wf-td">' . $media . '</div>';
	}
	?>

	<div class="blog-content wf-td">
		<h2 class="entry-title">
			<a href="javascript: void(0);" class="trigger-first-post-pp" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h2>

		<?php
		echo presscore_new_posted_on( 'dt_gallery' );
		?>

		<?php the_excerpt(); ?>

		<a href="javascript: void(0);" class="trigger-first-post-pp" rel="nofollow"><?php _ex( 'Details', 'details button', LANGUAGE_ZONE ); ?></a>

		<?php echo presscore_post_edit_link(); ?>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->

<?php do_action('presscore_after_post'); ?>