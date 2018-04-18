<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php the_title( sprintf('<h1 class="entry-title"><a href="%s">', esc_url( get_permalink() ) ),'</a></h1>' ); ?>

    <?php if( has_post_thumbnail() ): ?>

    <div class="thumbnails"><?php the_post_thumbnail('thumbnail'); ?></div>

    <?php endif; ?>
    </div>

</article>
