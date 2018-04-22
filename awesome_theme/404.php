<?php get_header(); ?>

    <div id="primary" class="container">
        <main id="main" class="site-main" role="main">

            <div class="error-404 not-found">

                <head class="page-header">
                    <h1 class="page-title">Sorry, page not found</h1>
                </head>

                <div class="page-content">

                    <h3>It looks like nothing was found at this location, maybe try one of the links below or a search?</h3>

                    <?php get_search_form() ?>

                    <?php the_widget('WP_Widget_Recent_Posts') ?>

                    <div class="widget widget_categories">
                        <h3>Check the most used categories</h3>
                        <ul>
                            <?php
                             wp_list_categories( array(
                                 'orderby'  => 'count',
                                 'order'    => 'DESC',
                                 'show_count'   => 1,
                                 'title_li'     => '',
                                 'number'       => 5,
                             ) );
                             ?>
                        </ul>
                    </div>

                    <?php the_widget('WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content") ?>

                </div>

            </div>

        </main>
    </div>

<?php get_footer(); ?>
