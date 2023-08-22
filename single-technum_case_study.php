<?php
/**
 * The template for displaying single case studies post
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage TechnUm
 * @since TechnUm 1.0
 */

the_post();
get_header();
$content_classes = 'content-wrapper';
$content_classes .= ' content-wrapper-sidebar-position-none';

$post_classes = 'single-post';
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
                        !empty(technum_case_studies_categories_output())
                    ) {
                        echo '<div class="post-labels">';
                            echo technum_case_studies_categories_output(true);
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
                    <?php
                        the_content();
                        $result_box_direction = !empty(technum_get_post_option('case_study_result')) && !empty(technum_get_post_option('case_study_boxes')) ? 'vertical' : 'horizontal';
                        if ( !empty(technum_get_post_option('case_study_result')) || !empty(technum_get_post_option('case_study_boxes')) ) {
                            echo '<div class="case-studies-results">';
                                echo '<h3>' . esc_html__('Results', 'technum') . '</h3>';
                                echo '<div class="results-wrapper">';
                                    if ( !empty(technum_get_post_option('case_study_result')) ) {
                                        echo '<div class="results-content">';
                                            echo do_shortcode( wpautop( rwmb_meta('case_study_result') ) );
                                        echo '</div>';
                                    }
                                    if ( !empty(technum_get_post_option('case_study_boxes')) ) {
                                        echo '<div class="results-boxes result-boxes-direction-' . esc_attr($result_box_direction) . '">';
                                            $boxes = technum_get_post_option('case_study_boxes');
                                            foreach ( $boxes as $box ) {
                                                echo '<div class="result-box">';
                                                    if ( !empty($box[0]) ) {
                                                        echo '<div class="result-box-value">' . esc_html($box[0]) . '</div>';
                                                    }
                                                    if ( !empty($box[1]) ) {
                                                        echo '<div class="result-box-title">' . esc_html($box[1]) . '</div>';
                                                    }
                                                echo '</div>';
                                            }
                                        echo '</div>';
                                    }
                                echo '</div>';
                            echo '</div>';
                        }
                    ?>
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
                        ( technum_get_prefered_option('post_tags_status') == 'on' && !empty(technum_case_studies_tags_output()) ) ||
                        ( technum_get_prefered_option('post_socials_status') == 'on' && !empty(technum_socials_output()) ) ||
                        ( technum_get_prefered_option('post_author_status') == 'on' && !empty(technum_post_author_output()) )
                    ) {
                        echo '<div class="post-meta-footer">';
                            if ( technum_get_prefered_option('post_author_status') == 'on' && !empty(technum_post_author_output()) ) {
                                echo technum_post_author_output(true);
                            }
                            if ( technum_get_prefered_option('post_tags_status') == 'on' && !empty(technum_case_studies_tags_output()) ) {
                                echo technum_case_studies_tags_output();
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

            </div>

        </div>

    </div>

<?php
get_footer();