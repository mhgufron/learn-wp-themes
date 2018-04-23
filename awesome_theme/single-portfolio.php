<?php get_header(); ?>

<div class="row">

    <div class="col-xs-12 col-sm-8">


        <?php

        if( have_posts() ):

            while( have_posts() ): the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    <?php the_title('<h1 class="entry-title">','</h1>'); ?>

                    <?php if( has_post_thumbnail() ): ?>

                        <div class="pull-right"><?php the_post_thumbnail('medium'); ?></div>

                    <?php endif; ?>

                    <small>
                        <?php

                        $terms_list = wp_get_post_terms($post->ID, 'field');

                        $i = 0;
                        foreach ($terms_list as $term) { $i++;
                            echo ($i > 1) ? ', ': '';
                            echo $term->name;
                        }

                          ?> || <?php

                          $terms_list = wp_get_post_terms($post->ID, 'software');

                          $i = 0;
                          foreach ($terms_list as $term) { $i++;
                              echo ($i > 1) ? ', ': '';
                              echo $term->name;
                          }

                            ?> || <?php edit_post_link(); ?></small>

                    <?php the_content(); ?>

                    <hr>

                    <div class="row">
                        <div class="col-xs-6 text-left"><?php previous_post_link(); ?></div>
                        <div class="col-xs-6 text-right"><?php next_post_link(); ?></div>
                    </div>

                </article>

            <?php endwhile;

        endif;

        ?>

    </div>

    <div class="col-xs-12 col-sm-4">
        <?php get_sidebar(); ?>
    </div>

</div>

<?php get_footer(); ?>
