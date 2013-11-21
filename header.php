<!DOCTYPE html>

<html <?php language_attributes(); ?> <?php soren_html_schema(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link href='//fonts.googleapis.com/css?family=Open+Sans:300,800,400&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<?php wp_head(); ?>
</head>
<?php do_action('soren_after_header'); //action ?>
<body <?php body_class(); ?>>

<?php do_action('soren_before_main'); //action ?>

<!-- Vulcan Header -->
<section class="push vulcan-header-wrap">
	<div class="vulcan-header">
		<div class="vulcan-header-inner">
			<h1 class="vulcan-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="soren-fader" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<p class="vulcan-site-description"><?php bloginfo( 'description' ); ?></p>
		</div>
	</div>
</section>

<?php soren_push_nav(); ?>

<main id="container" class="soren-content">
