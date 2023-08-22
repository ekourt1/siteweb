<?php
/**
 * The template for displaying single portfolio item page
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
?>

    <div class="<?php echo esc_attr($content_classes); ?>">

        <!-- Content Container -->
        <div class="content">

            <div id="portfolio-<?php the_ID(); ?>" class="single-portfolio">

                <?php if ( !empty(technum_media_gallery_output('portfolio_gallery')) ) {
                    echo '<div class="portfolio-post-gallery">';
                        echo technum_media_gallery_output('portfolio_gallery');
                    echo '</div>';
                ?>

                <div class="portfolio-post-content">
                    <?php
                        if ( !empty(get_the_title()) ) {
                            echo '<h2 class="portfolio-post-title">' . get_the_title() . '</h2>';
                        }
                    }
                    ?>

                    <?php the_content(); ?>

                    <div class="portfolio-post-meta">
                        <?php
                            if ( !empty(technum_taxonomy_output('technum_portfolio_category')) ) {
                                echo '<div class="portfolio-post-meta-item">';
                                    echo '<span class="portfolio-post-meta-label">' . esc_html__('Category:', 'technum') . '</span> ' . technum_taxonomy_output('technum_portfolio_category');
                                echo '</div>';
                            }
                            if ( !empty(technum_get_post_option('portfolio_author')) ) {
                                echo '<div class="portfolio-post-meta-item">';
                                    echo '<span class="portfolio-post-meta-label">' . esc_html__('Author:', 'technum') . '</span> ' . technum_get_post_option('portfolio_author');
                                echo '</div>';
                            }
                            if ( !empty(technum_get_post_option('portfolio_client')) ) {
                                echo '<div class="portfolio-post-meta-item">';
                                    echo '<span class="portfolio-post-meta-label">' . esc_html__('Client:', 'technum') . '</span> ' . technum_get_post_option('portfolio_client');
                                echo '</div>';
                            }
                        ?>
                    </div>
                </div>
            </div>

            <?php
                $args = array(
                    'prev_label'            => esc_html__('Prev post', 'technum'),
                    'next_label'            => esc_html__('Next post', 'technum'),
                    'taxonomy_name'         => 'technum_portfolio_category',
                    'taxonomy_separator'    => ' / '
                );
                echo technum_post_navigation($args);
            ?>

        </div>

        <!-- Sidebar Container -->
        <?php get_sidebar(); ?>

    </div>

<?php
get_footer();