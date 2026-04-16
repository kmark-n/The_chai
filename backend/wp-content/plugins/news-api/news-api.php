<?php
/**
 * Plugin Name: News API
 * Description: Custom post types and endpoints for news platform
 * Version: 1.0.0
 */

// Register custom post type
add_action('init', function() {
    register_post_type('article', [
        'labels' => ['name' => 'Articles', 'singular_name' => 'Article'],
        'public' => true,
        'show_in_rest' => true,
        'rest_base' => 'articles',
        'supports' => ['title', 'editor', 'excerpt', 'thumbnail', 'custom-fields'],
        'has_archive' => true,
        'rewrite' => ['slug' => 'articles'],
        'taxonomies' => ['category', 'post_tag'],
    ]);
});

// Register custom taxonomy
add_action('init', function() {
    register_taxonomy('article_category', 'article', [
        'label' => 'Article Categories',
        'show_in_rest' => true,
        'rest_base' => 'article-categories',
        'hierarchical' => true,
    ]);
});

// Add custom REST fields
add_action('rest_api_init', function() {
    // Adds featured_image_url to the JSON response
    register_rest_field('article', 'featured_image_url', [
        'get_callback' => function($post) {
            $image_id = get_post_thumbnail_id($post['id']);
            return $image_id ? wp_get_attachment_url($image_id) : null;
        },
    ]);

    // Adds author_name to the JSON response
    register_rest_field('article', 'author_name', [
        'get_callback' => function($post) {
            return get_the_author_meta('display_name', $post['author']) ?: 'Unknown Author';
        },
    ]);

    // Adds reading_time calculation
    register_rest_field('article', 'reading_time', [
        'get_callback' => function($post) {
            $content = $post['content']['rendered'];
            $word_count = str_word_count(strip_tags($content));
            return ceil($word_count / 200); 
        },
    ]);
});

// Custom endpoint for trending articles
add_action('rest_api_init', function() {
    register_rest_route('wp/v2', '/articles/trending', [
        'methods' => 'GET',
        'callback' => function() {
            $args = [
                'post_type' => 'article',
                'posts_per_page' => 5,
                'orderby' => 'meta_value_num',
                'meta_key' => 'views_count',
                'order' => 'DESC',
            ];
            $articles = get_posts($args);
            return rest_ensure_response($articles);
        },
        'permission_callback' => '__return_true',
    ]);
});
// Ensure Articles are included in the global search endpoint
add_filter('register_post_type_args', function($args, $post_type) {
    if ($post_type === 'article') {
        $args['show_in_rest'] = true;
    }
    return $args;
}, 10, 2);
