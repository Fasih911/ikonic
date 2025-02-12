<?php get_header(); ?>

<div class="container">
    <h1 class="page-title"><?php post_type_archive_title(); ?></h1>

    <?php if (have_posts()) : ?>
        <div class="projects-list">
            <?php while (have_posts()) : the_post(); ?>
                <div class="project-item">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a>
                    <?php endif; ?>
                    <p><?php the_excerpt(); ?></p>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Pagination -->
        <div class="pagination">
            <?php
            echo paginate_links(array(
                'total'     => $wp_query->max_num_pages,
                'current'   => max(1, get_query_var('paged', 1)),
                'format'    => 'page/%#%/', // ✅ Correct format
                'base'      => trailingslashit(get_post_type_archive_link('projects')) . 'page/%#%/', // ✅ Fix base URL
                'prev_text' => '&laquo; Previous',
                'next_text' => 'Next &raquo;',
            ));
            ?>
        </div>

    <?php else : ?>
        <p>No projects found.</p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
