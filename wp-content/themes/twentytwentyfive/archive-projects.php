<?php get_header(); ?>
<style>
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    text-align: center;
}

.projects-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    justify-content: center;
    align-items: stretch;
    margin-top: 20px;
}

.project-item {
    background: #ffffff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.project-item:hover {
    transform: translateY(-5px);
    box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.15);
}

.project-thumbnail img {
    width: 300px;
    height: 300px;
    border-radius: 10px;
}

.project-title {
    font-size: 1.5rem;
    margin: 10px 0;
    text-transform: capitalize;
}

.project-title a {
    text-decoration: none;
    color: #333;
    font-weight: bold;
    transition: color 0.3s ease;
}

.project-title a:hover {
    color: #0073e6;
}

.project-excerpt {
    font-size: 1rem;
    color: #666;
    padding: 0 15px 15px;
}

.pagination {
    margin-top: 30px;
}

.pagination a, .pagination span {
    padding: 10px 15px;
    margin: 5px;
    background: #0073e6;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: background 0.3s ease;
}

.pagination a:hover {
    background: #005bb5;
}

.pagination .current {
    background: #005bb5;
    font-weight: bold;
}

</style>
<div class="container">
    <h1 class="page-title"><?php post_type_archive_title(); ?></h1>
    <?php if (have_posts()) : ?>
        <div class="projects-list">
            <?php while (have_posts()) : the_post(); ?>
                <div class="project-item">
                    <div class="project-content">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>" class="project-thumbnail">
                                <?php the_post_thumbnail('medium'); ?>
                            </a>
                        <?php endif; ?>
                        <h2 class="project-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <p class="project-excerpt"><?php the_excerpt(); ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="pagination">
            <?php
            echo paginate_links(array(
                'total'     => $wp_query->max_num_pages,
                'current'   => max(1, get_query_var('paged', 1)),
                'format'    => 'page/%#%/',
                'base'      => trailingslashit(get_post_type_archive_link('projects')) . 'page/%#%/',
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
