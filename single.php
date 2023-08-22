<?php
/**
 * The template for displaying single gallery post
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage TechnUm
 * @since TechnUm 1.0
 */

the_post();
get_header();

$sidebar_args = technum_get_sidebar_args();
$sidebar_position = $sidebar_args['sidebar_position'];

$content_classes = 'content-wrapper';
$content_classes .= ' content-wrapper-sidebar-position-' . esc_attr($sidebar_position);
$content_classes .= ( technum_get_post_option('content_top_margin') == 'on' ? ' content-wrapper-remove-top-margin' : '' );
$content_classes .= ( technum_get_post_option('content_bottom_margin') == 'on' ? ' content-wrapper-remove-bottom-margin' : '' );

$post_format = get_post_format();
$post_classes = 'single-post' . ( $post_format == 'quote' && technum_post_options() && !empty(technum_get_post_option('post_media_quote_text')) ? '  technum-format-quote' : '' );
?>

    <div class="<?php echo esc_attr($content_classes); ?>">

        <!-- Content Container -->
        <div class="content">

            <div id="post-<?php the_ID(); ?>" <?php post_class($post_classes); ?>>

                <?php
                    if (
                        technum_get_prefered_option('post_media_image_status') == 'on' &&
                        !empty(technum_post_media_output())
                    ) {
                        echo '<div class="post-media-wrapper">';
                            echo technum_post_media_output();
                        echo '</div>';
                    }

                    if (
                        technum_get_prefered_option('post_category_status') == 'on' &&
                        !empty(technum_post_categories_output())
                    ) {
                        echo '<div class="post-labels">';
                            echo technum_post_categories_output(true);
                        echo '</div>';
                    }

                    if (
                        technum_get_prefered_option('post_date_status') == 'on' &&
                        !empty(technum_post_date_output())
                    ) {
                        echo '<div class="post-meta-header">';
                            if ( technum_get_prefered_option('post_date_status') == 'on' && !empty(technum_post_date_output()) ) {
                                echo technum_post_date_output(true);
                            }
                        echo '</div>';
                    }
                ?>

                <?php
                    if ( technum_get_prefered_option('post_title_status') == 'on' && !empty(get_the_title()) ) {
                        echo '<h3 class="post-title">' . get_the_title() . '</h3>';
                    }
                ?>

                <div class="post-content">
                    <?php the_content(); ?>
                </div>

                <?php
                    wp_link_pages(
                        array(
                            'before' => '<div class="content-pagination"><nav class="pagination"><div class="nav-links">',
                            'after' => '</div></nav></div>'
                        )
                    );
                ?>

                <?php
                    if (
                        ( technum_get_prefered_option('post_tags_status') == 'on' && !empty(technum_post_tags_output()) ) ||
                        ( technum_get_prefered_option('post_socials_status') == 'on' && !empty(technum_socials_output()) ) ||
                        ( technum_get_prefered_option('post_author_status') == 'on' && !empty(technum_post_author_output()) )
                    ) {
                        echo '<div class="post-meta-footer">';
                            if ( technum_get_prefered_option('post_author_status') == 'on' && !empty(technum_post_author_output()) ) {
                                echo technum_post_author_output(true);
                            }
                            if ( technum_get_prefered_option('post_tags_status') == 'on' && !empty(technum_post_tags_output()) ) {
                                echo technum_post_tags_output();
                            }
                            if ( technum_get_prefered_option('post_socials_status') == 'on' && !empty(technum_socials_output()) ) {
                                echo '<div class="post-meta-item post-meta-item-socials">';
                                    echo technum_socials_output('wrapper-socials');
                                echo '</div>';
                            }
                        echo '</div>';
                    }
                ?>

                <?php
                    comments_template();
                ?>

                <?php
                    if (technum_get_prefered_option('recent_posts_status') == 'on') {
                        technum_recent_posts_output(
                            array(
                                'orderby'               => technum_get_prefered_option('recent_posts_order_by'),
                                'numberposts'           => technum_get_prefered_option('recent_posts_number'),
                                'post_type'             => get_post_type(),
                                'order'                 => technum_get_prefered_option('recent_posts_order'),
                                'show_media'            => technum_get_prefered_option('recent_posts_image'),
                                'show_category'         => technum_get_prefered_option('recent_posts_category'),
                                'show_title'            => technum_get_prefered_option('recent_posts_title'),
                                'show_date'             => technum_get_prefered_option('recent_posts_date'),
                                'show_author'           => technum_get_prefered_option('recent_posts_author'),
                                'show_excerpt'          => technum_get_prefered_option('recent_posts_excerpt'),
                                'excerpt_length'        => technum_get_prefered_option('recent_posts_excerpt_length'),
                                'show_tags'             => technum_get_prefered_option('recent_posts_tags'),
                                'show_more'             => technum_get_prefered_option('recent_posts_more')
                            )
                        );
                    }
                ?>

            </div>

        </div>

        <!-- Sidebar Container -->
        <?php get_sidebar(); ?>

    </div>

<?php
get_footer();