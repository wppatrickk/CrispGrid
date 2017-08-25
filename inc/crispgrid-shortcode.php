<?php
/*
 * @author    Crisp Themes
 * @copyright Copyright (c) 2017, Crisp Themes, https://www.crispthemes.com
 * @license   http://en.wikipedia.org/wiki/MIT_License The MIT License
*/

function crispgrid_shortcode($atts) {  
	ob_start();
	
	extract( shortcode_atts( array(
        'p' => '',
    ), $atts ) );

	$postid = $atts['id'];

	$crispgrid_type = get_post_meta($postid, 'crispgrid_type', true);
	$crispgrid_cols = get_post_meta($postid, 'crispgrid_cols', true);
	$crispgrid_display = get_post_meta($postid, 'crispgrid_display', true);
	if (!$crispgrid_display) {
		$crispgrid_display = 'square';
	}
	$crispgrid_nop = get_post_meta($postid, 'crispgrid_nop', true);
	$crispgrid_image = get_post_meta($postid, 'crispgrid_image', true);
	$crispgrid_date = get_post_meta($postid, 'crispgrid_date', true);
	$crispgrid_author = get_post_meta($postid, 'crispgrid_author', true);
	$crispgrid_excerpt = get_post_meta($postid, 'crispgrid_excerpt', true);
	$crispgrid_excerpt_text = get_post_meta($postid, 'crispgrid_excerpt_text', true);
	$crispgrid_link = get_post_meta($postid, 'crispgrid_link', true);
	$crispgrid_link_text = get_post_meta($postid, 'crispgrid_link_text', true);
	$crispgrid_bgcolor = get_post_meta($postid, 'crispgrid_bgcolor', true);
	$crispgrid_color = get_post_meta($postid, 'crispgrid_color', true);
	$crispgrid_bgcolor_hover = get_post_meta($postid, 'crispgrid_bgcolor_hover', true);
	$crispgrid_color_hover = get_post_meta($postid, 'crispgrid_color_hover', true);

	wp_register_style( 'crispgrid-style', plugins_url( '../css/crispgrid-style.css', __FILE__ ), array(), '1.0', 'screen' );
	wp_enqueue_style( 'crispgrid-style' );

	wp_enqueue_script( 'jquery' );
	
	if ($crispgrid_nop) {
		$args = array('post_type' => $crispgrid_type, 'posts_per_page' => $crispgrid_nop);
	} else {
		$args = array('post_type' => $crispgrid_type);
	}
	

	$grid_posts = new WP_Query($args);

   	if($grid_posts->have_posts()) : ?>
   		<div id="crispgrid-post-grid-<?php echo $postid; ?>" class="crispgrid-post-grid <?php echo $crispgrid_display; ?>">
   			<style type="text/css">
   				#crispgrid-post-grid-<?php echo $postid; ?> .crispgrid-link a {
   					<?php if ($crispgrid_bgcolor) { ?>
   						background-color: <?php echo $crispgrid_bgcolor; ?>;
   					<?php } ?>
   					<?php if ($crispgrid_color) { ?>
   						color: <?php echo $crispgrid_color; ?>;
   					<?php } ?>
   				}

   				#crispgrid-post-grid-<?php echo $postid; ?> .crispgrid-link a:hover {
   					<?php if ($crispgrid_bgcolor_hover) { ?>
   						background-color: <?php echo $crispgrid_bgcolor_hover; ?>;
   					<?php } ?>
   					<?php if ($crispgrid_color_hover) { ?>
   						color: <?php echo $crispgrid_color_hover; ?>;
   					<?php } ?>
   				}
   			</style>
			<div class="crispgrid-cols-<?php echo $crispgrid_cols; ?> crispgrid-cols">
      			<?php while($grid_posts->have_posts()) : 
				$grid_posts->the_post(); ?>
         		<div class="crispgrid">
         			<div class="crispgrid-inner <?php if ($crispgrid_image == 'on') { echo 'no-image'; } ?> <?php if ($crispgrid_date == 'on') { echo 'no-date'; } ?> <?php if ($crispgrid_author == 'on') { echo 'no-author'; } ?> <?php if ($crispgrid_excerpt == 'on') { echo 'no-excerpt'; } ?> <?php if ($crispgrid_link == 'on') { echo 'no-readmore'; } ?>">
         				<?php if ($crispgrid_image == 'off') { ?>
         				<div class="crispgrid-image" style="background-image: url(<?php the_post_thumbnail_url('large'); ?>);">
         					<a href="<?php the_permalink(); ?>"></a>
         				</div>
         				<?php } ?>
	         			<div class="crispgrid-details">
	         				<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	         				<div class="crispgrid-meta">
	         					<?php 
	         					$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
								$time_string = sprintf( $time_string,
									esc_attr( get_the_date( 'c' ) ),
									esc_html( get_the_date() ),
									esc_attr( get_the_modified_date( 'c' ) ),
									esc_html( get_the_modified_date() )
								);

								$posted_on = sprintf(
									'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
								);

								$byline = sprintf(
									'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
								); ?>

	         					<?php if ($crispgrid_date == 'off') { ?>
	         					<div class="crispgrid-date">
	         						<?php echo $posted_on; ?>
	         					</div>
	         					<?php } ?>

	         					<?php if ($crispgrid_author == 'off') { ?>
	         					<div class="crispgrid-author">
	         						<?php echo $byline; ?>
	         					</div>
	         					<?php } ?>

	         					<div class="clear"></div>
	         				</div>

	         				<?php if ($crispgrid_excerpt == 'off') { ?>
	         				<div class="crispgrid-excerpt">
	         					<?php $content = get_the_content();
	         					if ($crispgrid_excerpt_text) {
	         						$excerpt = wp_trim_words($content, $crispgrid_excerpt_text);
	         					} else {
	         						$excerpt = wp_trim_words($content, 30);
	         					} ?>
	         					<p><?php echo $excerpt; ?></p>
	         				</div>
	         				<?php } ?>

	         				<?php if ($crispgrid_link == 'off') { ?>
	         				<div class="crispgrid-link">
	         					<a href="<?php the_permalink(); ?>">
	         						<?php if ($crispgrid_link_text) {
	         							echo $crispgrid_link_text;
	         						} else {
	         							echo 'Read More';
	         						} ?>
	         					</a>
	         				</div>
	         				<?php } ?>
	         			</div>
	         		</div>
         		</div>
         		<?php endwhile; ?>
			</div>
		</div>
	<?php endif;
	wp_reset_query();
	$crisp_grid = ob_get_clean();
	return $crisp_grid;
}  

add_shortcode('crispgrid', 'crispgrid_shortcode');
?>