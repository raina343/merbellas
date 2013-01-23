<?php /* Template Name: MerbellaBlog */ 

get_header(); ?>

        <div id="primary" class="site-content2">
                <div id="content2" role="main2">


<?php
$temp = $wp_query;
$wp_query= null;
$wp_query = new WP_Query();
$wp_query->query('posts_per_page=5'.'&paged='.$paged);
echo "<PRE>";
//print_r($wp_query);
while ($wp_query->have_posts()) : $wp_query->the_post();
print_r($wp_query);

	get_template_part( 'content', get_post_format() ); 
	$wp_query = null; $wp_query = $temp;
                                 endwhile; ?>


/*
if ( have_posts() ) : ?>
	while ( have_posts() ) : the_post(); 
	get_template_part( 'content', get_post_format() ); 
	endwhile;
	else :
endif;?>
*/
