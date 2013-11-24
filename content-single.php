<?php
/**
 * @package Soren
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="row">

		<time class="vulcan-meta col-md-9" datetime="<?php the_date('F jS, Y'); ?>" itemprop="datePublished" pubdate><?php echo the_time('F jS, Y'); ?></time>

		<section class="vulcan-post-shares col-md-3 tar">
			<?php echo soren_post_shares(true);?>
		</section>
	</header>

	<h2 class="vulcan-entry-title" itemprop="title"><a class="soren-fader" href="<?php the_permalink();?>"><?php the_title();?></a></h2>

	<section class="vulcan-entry-content" itemprop="content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'vulcan' ) ); ?>
	</section>

	<footer class="vulcan-post-footer">
		<?php echo soren_post_author(true, 80);?>
	</footer>
</article><!-- #post-## -->