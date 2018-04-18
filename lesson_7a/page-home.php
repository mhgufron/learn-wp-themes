<?php get_header(); ?>
<div class="row">
    <div class="col-xs-12">

        <?php
            $args = array(
                'type' => 'post',
                'posts_per_page' => 3,
            );
            $lastBlog = new WP_Query($args);

            if( $lastBlog->have_posts() ):

                while( $lastBlog->have_posts() ): $lastBlog->the_post(); ?>

                <?php get_template_part('template-parts/content','featured'); ?>

                <?php endwhile;

            endif;

            wp_reset_postdata();
         ?>

    </div>
    <div class="col-xs-12 col-sm-8">
        <?php

        if( have_posts() ):

            while( have_posts() ): the_post(); ?>

            <?php get_template_part('template-parts/content',get_post_format()); ?>

            <?php endwhile;

        endif;

        // Print Other 2 Post Not The First One

        /*
        $lastBlog = new WP_Query('type=post&posts_per_page=2&offset=1');

        if( $lastBlog->have_posts() ):

            while( $lastBlog->have_posts() ): $lastBlog->the_post(); ?>

            <?php get_template_part('template-parts/content',get_post_format()); ?>

            <?php endwhile;

        endif;

        wp_reset_postdata();
        */
        ?>

        <!-- <hr> -->

        <?php
        // Print Only Tutorials

        /*
        $args = array(
            'type'          => 'post',
            'post_per_page' => 2,
            'category_name' => 'tutorial',
        );
        $lastBlog = new WP_Query($args);

        if( $lastBlog->have_posts() ):

            while( $lastBlog->have_posts() ): $lastBlog->the_post(); ?>

            <?php get_template_part('template-parts/content',get_post_format()); ?>

            <?php endwhile;

        endif;

        wp_reset_postdata();
        */

        ?>

    </div>
    <div class="col-xs-12 col-sm-4">

        <?php get_sidebar(); ?>
    </div>

</div>
<?php get_footer(); ?>
