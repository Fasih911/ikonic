<?php
/**
 * Twenty Twenty-Five functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

// Adds theme support for post formats.
if ( ! function_exists( 'twentytwentyfive_post_format_setup' ) ) :
	/**
	 * Adds theme support for post formats.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_post_format_setup() {
		add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );
	}
endif;
add_action( 'after_setup_theme', 'twentytwentyfive_post_format_setup' );

// Enqueues editor-style.css in the editors.
if ( ! function_exists( 'twentytwentyfive_editor_style' ) ) :
	/**
	 * Enqueues editor-style.css in the editors.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_editor_style() {
		add_editor_style( get_parent_theme_file_uri( 'assets/css/editor-style.css' ) );
	}
endif;
add_action( 'after_setup_theme', 'twentytwentyfive_editor_style' );

// Enqueues style.css on the front.
if ( ! function_exists( 'twentytwentyfive_enqueue_styles' ) ) :
	/**
	 * Enqueues style.css on the front.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_enqueue_styles() {
		wp_enqueue_style(
			'twentytwentyfive-style',
			get_parent_theme_file_uri( 'style.css' ),
			array(),
			wp_get_theme()->get( 'Version' )
		);
	}
endif;
add_action( 'wp_enqueue_scripts', 'twentytwentyfive_enqueue_styles' );

// Registers custom block styles.
if ( ! function_exists( 'twentytwentyfive_block_styles' ) ) :
	/**
	 * Registers custom block styles.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_block_styles() {
		register_block_style(
			'core/list',
			array(
				'name'         => 'checkmark-list',
				'label'        => __( 'Checkmark', 'twentytwentyfive' ),
				'inline_style' => '
				ul.is-style-checkmark-list {
					list-style-type: "\2713";
				}

				ul.is-style-checkmark-list li {
					padding-inline-start: 1ch;
				}',
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_block_styles' );

// Registers pattern categories.
if ( ! function_exists( 'twentytwentyfive_pattern_categories' ) ) :
	/**
	 * Registers pattern categories.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_pattern_categories() {

		register_block_pattern_category(
			'twentytwentyfive_page',
			array(
				'label'       => __( 'Pages', 'twentytwentyfive' ),
				'description' => __( 'A collection of full page layouts.', 'twentytwentyfive' ),
			)
		);

		register_block_pattern_category(
			'twentytwentyfive_post-format',
			array(
				'label'       => __( 'Post formats', 'twentytwentyfive' ),
				'description' => __( 'A collection of post format patterns.', 'twentytwentyfive' ),
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_pattern_categories' );

// Registers block binding sources.
if ( ! function_exists( 'twentytwentyfive_register_block_bindings' ) ) :
	/**
	 * Registers the post format block binding source.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_register_block_bindings() {
		register_block_bindings_source(
			'twentytwentyfive/format',
			array(
				'label'              => _x( 'Post format name', 'Label for the block binding placeholder in the editor', 'twentytwentyfive' ),
				'get_value_callback' => 'twentytwentyfive_format_binding',
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_register_block_bindings' );

// Registers block binding callback function for the post format name.
if ( ! function_exists( 'twentytwentyfive_format_binding' ) ) :
	/**
	 * Callback function for the post format name block binding source.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return string|void Post format name, or nothing if the format is 'standard'.
	 */
	function twentytwentyfive_format_binding() {
		$post_format_slug = get_post_format();

		if ( $post_format_slug && 'standard' !== $post_format_slug ) {
			return get_post_format_string( $post_format_slug );
		}
	}
endif;

// new work
function custom_post_type_projects() {
    $args = array(
        'label'               => __('Projects', 'textdomain'),
        'public'              => true,
        'show_in_rest'        => true,
        'supports'            => array('title', 'editor', 'thumbnail', 'excerpt'),
        'has_archive'         => true,
        'rewrite'             => array('slug' => 'projects', 'with_front' => false),
        'menu_icon'           => 'dashicons-portfolio',
        'query_var'           => true,
    );
    register_post_type('projects', $args);
}
add_action('init', 'custom_post_type_projects');

function custom_taxonomy_project_type() {
    $args = array(
        'label'             => __('Project Type', 'textdomain'),
        'public'            => true,
        'show_in_rest'      => true,
        'hierarchical'      => true,
        'rewrite'           => array('slug' => 'project-type'),
    );
    register_taxonomy('project-type', array('projects'), $args);
}
add_action('init', 'custom_taxonomy_project_type');

function modify_projects_archive_query($query) {
    if (!is_admin() && $query->is_main_query() && is_post_type_archive('projects')) {
        $query->set('posts_per_page', 6);
    }
}
add_action('pre_get_posts', 'modify_projects_archive_query');


add_action('wp_ajax_get_architecture_projects', 'get_architecture_projects');
add_action('wp_ajax_nopriv_get_architecture_projects', 'get_architecture_projects');

function get_architecture_projects() {
    $posts_per_page = is_user_logged_in() ? 6 : 3;

    $args = array(
        'post_type'      => 'projects',
        'posts_per_page' => $posts_per_page,
        'tax_query'      => array(
            array(
                'taxonomy' => 'project-type',
                'field'    => 'slug',
                'terms'    => 'architecture',
            ),
        ),
    );

    $query = new WP_Query($args);
    $projects = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $projects[] = array(
                'id'    => get_the_ID(),
                'title' => get_the_title(),
                'link'  => get_permalink(),
            );
        }
    }
    wp_reset_postdata();
    wp_send_json(array(
        'success' => true,
        'data'    => $projects
    ));

    wp_die();
}

function enqueue_jquery() {
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'enqueue_jquery');

function enqueue_ajax_script() {
    wp_enqueue_script('custom-ajax', get_template_directory_uri() . '/assets/js/custom-ajax.js', array('jquery'), null, true);

    wp_localize_script('custom-ajax', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_ajax_script');


function hs_give_me_coffee() {
    $api_url = "https://coffee.alexflipnote.dev/random.json";
    $response = wp_remote_get($api_url);
    if (is_wp_error($response)) {
        return 'Error fetching coffee image';
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    if (!empty($data['file'])) {
        return esc_url($data['file']);
    }

    return 'No coffee image found!';
}

function coffee_shortcode() {
    return '<img src="' . hs_give_me_coffee() . '" alt="Random Coffee">';
}
add_shortcode('coffee', 'coffee_shortcode');


function hs_get_kanye_quotes() {
    $api_url = "https://api.kanye.rest";
    $quotes = array();
    for ($i = 0; $i < 5; $i++) {
        $response = wp_remote_get($api_url);
        if (!is_wp_error($response)) {
            $body = wp_remote_retrieve_body($response);
            $data = json_decode($body, true);
            if (!empty($data['quote'])) {
                $quotes[] = esc_html($data['quote']);
            }
        }
    }
    if (!empty($quotes)) {
        $output = '<div class="kanye-quotes"><h2>Kanye West Quotes</h2><ul>';
        foreach ($quotes as $quote) {
            $output .= '<li>"' . $quote . '"</li>';
        }
        $output .= '</ul></div>';
        return $output;
    }

    return 'No quotes found!';
}
function hs_kanye_quotes_shortcode() {
    return hs_get_kanye_quotes();
}
add_shortcode('kanye_quotes', 'hs_kanye_quotes_shortcode');
