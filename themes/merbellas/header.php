<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if !IE]><!-->
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css_styles.php" />
<!--<![endif]-->
<!--[if IE 9]>
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css_styles.php" />
<!--<![endif]-->
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css_styles.php?type=ie8" />
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

<?php wp_head(); ?>
<!--[if IE 8]> 
<script src="<?php echo get_template_directory_uri(); ?>/js/respond.min.js" type="text/javascript"></script> 
<![endif]--> 
</head>

<body <?php body_class(); ?>>
<body>
    <div id="wrapper">
        <div id="header">
                <div id="innerheader">
                        <div id="logo"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png"></div>
                </div>
        </div>
        <div id="content">
                <div id="d1">&nbsp;</div>
                <div id="d3">&nbsp;</div>
                <div id="d2">&nbsp;
                        <div id="spacer" style="height:50px;"></div>
                        <div id="navbar">
                                <div id="innernav">
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu99') ); ?>
				</div>
	                </div>
                        <div id="spacer" style="height:20px;"></div>
<div id="hirepanel">
<table width="100%" cellspacing="0" cellpadding="0" border="1">
<tr><td colspan="4"><img src="<?php echo get_template_directory_uri(); ?>/images/hireperformer.png"></td></tr>
<tr><td><img src="<?php echo get_template_directory_uri(); ?>/images/rss.png"></td>
<td><A HREF="http://www.facebook.com/merbellas"><img src="<?php echo get_template_directory_uri(); ?>/images/facebook.png" border="0"></a></td>
<td><A HREF="http://www.etsy.com/shop/StrangeCupOfTea"><img src="<?php echo get_template_directory_uri(); ?>/images/etsy.png" border="0"></a></td>
<td><A HREF="http://www.youtube.com/user/MerBellas"><img src="<?php echo get_template_directory_uri(); ?>/images/youtube.png" border="0"></a></td></tr>
</table>
</div>
                        <div id="centercontentpanel">
                                <div id="innertop"></div>
                                <div id="innerd1">&nbsp;</div>
                                <div id="innerd3">&nbsp;</div>
                                <div id="innerd2">
				<div id="page2" class="hfeed2 site2">
