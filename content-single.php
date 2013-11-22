<?php
/**
 * @package Soren
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="row">

		<time class="soren-entry-date col-md-9" datetime="<?php the_date('F jS, Y'); ?>" itemprop="datePublished" pubdate><?php echo the_time('F jS, Y'); ?></time>

		<section class="vulcan-post-shares col-md-3">
			<?php echo soren_post_shares(true);?>
		</section>
	</header>

	<h2 class="soren-entry-title" itemprop="title"><a class="soren-fader" href="<?php the_permalink();?>"><?php the_title();?></a></h2>

	<section class="soren-entry-content" itemprop="content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'soren' ) ); ?>
	</section>

	<footer class="vulcan-post-footer row">
		<?php echo soren_post_author();?>
	</footer>
</article><!-- #post-## -->