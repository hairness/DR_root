<?php 

	/* INDEX:PHP */
	
	get_header(); 
?>

	<?php if (have_posts()) : ?>

		<h2>Index</h2>


		<?php while (have_posts()) : the_post(); ?>

			<div <?php post_class() ?> id="post-<?php the_ID(); ?>">

				<h2><?php the_title(); ?></h2>


				<div class="entry">

					<?php the_excerpt(); ?>

				</div>

			</div>

		<?php endwhile; ?>


	<?php else : ?>

		<h2>No posts found.</h2>

	<?php endif; ?>

<?php //get_sidebar(); ?>

<?php get_footer(); ?>
