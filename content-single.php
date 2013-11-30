<?php
/**
 * @package Soren
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header>

		<time class="vulcan-meta" datetime="<?php the_date('F jS, Y'); ?>" itemprop="datePublished" pubdate><?php echo the_time('F jS, Y'); ?></time>
	</header>

	<h2 class="vulcan-entry-title" itemprop="title"><a class="soren-fader" href="<?php the_permalink();?>"><?php the_title();?></a></h2>

	<section class="vulcan-entry-content" itemprop="content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'vulcan' ) ); ?>
	</section>

	<section class="vulcan-post-shares">
		<?php echo soren_post_shares();?>
		<a class="show-soren-comments" href="#soren-comments-wrap"><i class="sorencon sorencon-comments"></i></a>
	</section>

	<footer class="vulcan-post-footer">
		<?php echo soren_post_author(true, 80, true);?>
	</footer>
</article><!-- #post-## -->