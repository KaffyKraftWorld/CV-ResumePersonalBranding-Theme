<?php get_header(); ?>

<main id="main-content" class="site-main">
    <div class="container">
        <div class="row">
            <div class="col-md-8">

                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header class="entry-header">
                            <h1 class="entry-title"><?php the_title(); ?></h1>
                            <div class="entry-meta">
                                <span class="posted-on"><?php the_time('F j, Y'); ?></span>
                                <span class="byline"><?php _e('by', 'personal-branding-child'); ?> <?php the_author_posts_link(); ?></span>
                            </div>
                        </header>

                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>

                        <footer class="entry-footer">
                            <?php the_tags(__('Tags:', 'personal-branding-child') . ' ', ', ', ''); ?>
                        </footer>
                    </article>
                <?php endwhile; endif; ?>

            </div>

            <div class="col-md-4">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
