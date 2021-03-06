<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 */

get_header(); ?>

			<?$temp = $wp_query;
			$wp_query= null;
			$wp_query = new WP_Query();
			$wp_query->query('posts_per_page=5'.'&paged='.$paged);
			while ($wp_query->have_posts()) : $wp_query->the_post();
				get_template_part( 'content', get_post_format() ); 
			endwhile; 

			$wp_query = null; $wp_query = $temp;?>

<?php get_footer(); ?>
