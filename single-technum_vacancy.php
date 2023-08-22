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

            <div id="vacancy-<?php the_ID(); ?>" class="single-vacancy">

                <div class="vacancy-post-content">

                    <?php
                        if ( !empty(get_the_content()) ) {
                            echo '<h4>' . esc_html__('Job Description:', 'technum') . '</h4>';
                            the_content();
                        }

                        if (!empty(technum_get_post_option('vacancy_responsibilities'))) {
                            echo '<h4>' . esc_html__('Responsibilities:', 'technum') . '</h4>';
                            echo do_shortcode( wpautop( rwmb_meta('vacancy_responsibilities') ) );;
                        }

                        if (!empty(technum_get_post_option('vacancy_qualifications'))) {
                            echo '<h4>' . esc_html__('Preferred Qualifications:', 'technum') . '</h4>';
                            echo do_shortcode( wpautop( rwmb_meta('vacancy_qualifications') ) );;
                        }

                    ?>

                    <?php
                        if ( !empty(technum_get_post_option('vacancy_button')) ) {
                            $button = technum_get_post_option('vacancy_button');
                            echo '<div class="vacancy-post-button">';
                                echo '<a href="' . esc_url( $button[0] ) . '" class="technum-button">' . esc_html( $button[1] ) . '</a>';
                            echo '</div>';
                        }
                    ?>

                </div>
            </div>

        </div>

        <!-- Sidebar Container -->
        <?php
            $sidebar_args              = technum_get_sidebar_args();
            $technum_sidebar_name      = $sidebar_args['sidebar_name'];
            $technum_sidebar_position  = $sidebar_args['sidebar_position'];
            $additional_class          = $sidebar_args['additional_class'];

            echo '<div class="sidebar sidebar-position-' . esc_attr($technum_sidebar_position) . esc_attr($additional_class) . '">';
                echo '<div class="vacancy-info">';

                    if ( !empty(technum_get_post_option('vacancy_occupation')) || !empty(technum_get_post_option('vacancy_location')) ) {
                        echo '<div class="vacancy-post-meta">';
                        if (!empty(technum_get_post_option('vacancy_occupation'))) {
                            echo '<div class="vacancy-post-meta-item vacancy-occupation">';
                                echo esc_html(technum_get_post_option('vacancy_occupation'));
                            echo '</div>';
                        }
                        if (!empty(technum_get_post_option('vacancy_location'))) {
                            echo '<div class="vacancy-post-meta-item">';
                                echo esc_html(technum_get_post_option('vacancy_location'));
                            echo '</div>';
                        }
                        echo '</div>';
                    }

                    if ( !empty(get_the_title()) ) {
                        echo '<h3 class="vacancy-post-title">' . get_the_title() . '</h3>';
                    }

                    if ( !empty(technum_get_post_option('vacancy_salary')) ) {
                        echo '<div class="vacancy-salary">';
                            echo '<div class="vacancy-salary-label">' . esc_html__('Salary', 'technum') . '</div>';
                            echo '<div class="vacancy-salary-value">' . esc_html(technum_get_post_option('vacancy_salary')) . '</div>';
                        echo '</div>';
                    }

                echo '</div>';
                if ($technum_sidebar_position !== 'none' && is_active_sidebar($technum_sidebar_name) ) {
                    dynamic_sidebar($technum_sidebar_name);
                }
                echo '<div class="shop-hidden-sidebar-close"></div>';
            echo '</div>';
            echo '<div class="simple-sidebar-trigger"></div>';
        ?>

    </div>

    <?php
        if ( technum_get_prefered_option('recent_vacancies_status') == 'on' ) {
            echo '<div class="content-wrapper content-wrapper-sidebar-position-none">';
                echo '<div class="content">';
                    if ( !empty(technum_get_prefered_option('recent_vacancies_section_heading')) ) {
                        echo '<div class="related-vacancy-title special-title">';
                            echo '<div class="special-title-backward">' . esc_html__('Careers', 'technum') . '</div>';
                            echo '<h2 class="team-post-title">' . technum_get_prefered_option('recent_vacancies_section_heading') . '</h2>';
                        echo '</div>';
                    }

                    $query = new WP_Query( [
                        'post_type'         => 'technum_vacancy',
                        'columns_number'    => 1,
                        'posts_per_page'    => technum_get_prefered_option('recent_vacancies_number'),
                        'orderby'           => technum_get_prefered_option('recent_vacancies_order_by'),
                        'order'             => technum_get_prefered_option('recent_vacancies_order')
                    ] );

                    echo '<div class="archive-listing">';
                        echo '<div class="archive-listing-wrapper vacancy-listing-wrapper">';
                            while( $query->have_posts() ){
                                $query->the_post();
                                get_template_part('content', 'technum_vacancy');
                            };
                            wp_reset_postdata();
                        echo '</div>';
                    echo '</div>';

                echo '</div>';
            echo '</div>';
        }
    ?>

<?php
get_footer();