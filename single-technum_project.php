<?php
/**
 * The template for displaying single project item page
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

            <div id="project-<?php the_ID(); ?>" class="single-project">

                <?php if ( !empty(technum_media_gallery_output('project_gallery')) ) {
                    echo '<div class="project-post-gallery">';
                        echo technum_media_gallery_output('project_gallery');
                    echo '</div>';
                ?>

                <div class="project-post-content">
                    <?php
                        if ( !empty(get_the_title()) ) {
                            echo '<h2 class="project-post-title">' . get_the_title() . '</h2>';
                        }
                    }
                    ?>

                    <?php the_content(); ?>

                    <div class="project-post-meta">
                        <?php
                            if ( !empty(technum_get_post_option('project_strategy')) ) {
                                echo '<div class="project-post-meta-item">';
                                    echo '<div class="project-post-meta-label">' . esc_html__('Strategy', 'technum') . '</div>';
                                    $strategy_list = technum_get_post_option('project_strategy');
                                    echo wp_kses( implode(', <br>', $strategy_list ), array('br' => array()) );
                                echo '</div>';
                            }
                            if ( !empty(technum_get_post_option('project_design')) ) {
                                echo '<div class="project-post-meta-item">';
                                    echo '<div class="project-post-meta-label">' . esc_html__('Design', 'technum') . '</div>';
                                    $design_list = technum_get_post_option('project_design');
                                    echo wp_kses( implode(', <br>', $design_list ), array('br' => array()) );
                                echo '</div>';
                            }
                            if ( !empty(technum_get_post_option('project_client')) ) {
                                echo '<div class="project-post-meta-item">';
                                    echo '<div class="project-post-meta-label">' . esc_html__('Client', 'technum') . '</div>';
                                    echo esc_html(technum_get_post_option('project_client'));
                                echo '</div>';
                            }
                        ?>
                    </div>

                    <?php
                        if ( !empty(technum_get_post_option('project_button')) ) {
                            $button = technum_get_post_option('project_button');
                            echo '<div class="project-post-button">';
                                echo '<a href="' . esc_url( $button[0] ) . '" class="technum-button">' . esc_html( $button[1] ) . '</a>';
                            echo '</div>';
                        }
                    ?>

                </div>
            </div>

            <?php
                $args = array(
                    'prev_label'            => esc_html__('Prev project', 'technum'),
                    'next_label'            => esc_html__('Next project', 'technum'),
                    'taxonomy_name'         => 'technum_project_category',
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