<div <?php post_class('vacancy-item-wrapper'); ?>>
    <div class="vacancy-item">

        <?php
            if ( !empty(technum_get_post_option('vacancy_occupation')) || !empty(technum_get_post_option('vacancy_location')) || !empty(get_the_title()) ) {
                echo '<div class="vacancy-item-header">';
                    if (!empty(technum_get_post_option('vacancy_occupation')) || !empty(technum_get_post_option('vacancy_location'))) {
                        echo '<div class="vacancy-post-meta">';
                        if (!empty(technum_get_post_option('vacancy_occupation'))) {
                            echo '<div class="vacancy-post-meta-item vacancy-occupation">';
                                echo esc_html(technum_get_post_option('vacancy_occupation'));
                            echo '</div>';
                        }
                        if (!empty(technum_get_post_option('vacancy_location'))) {
                            echo '<div class="vacancy-post-meta-item vacancy-city">';
                                echo esc_html(technum_get_post_option('vacancy_location'));
                            echo '</div>';
                        }
                        echo '</div>';
                    }

                    if (!empty(get_the_title())) {
                        echo '<h4 class="vacancy-post-title">' . get_the_title() . '</h4>';
                    }
                echo '</div>';
            }
        ?>

        <div class="vacancy-item-excerpt">
            <?php
                $excerpt_length = technum_get_theme_mod('vacancy_archive_excerpt_length');
                echo substr(get_the_excerpt(), 0, $excerpt_length);
            ?>
        </div>

        <?php
            if ( !empty(technum_get_post_option('vacancy_salary')) ) {
                echo '<div class="vacancy-item-salary">';
                    echo '<div class="vacancy-salary">';
                        echo '<div class="vacancy-salary-label">' . esc_html__('Salary', 'technum') . '</div>';
                        echo '<div class="vacancy-salary-value">' . esc_html(technum_get_post_option('vacancy_salary')) . '</div>';
                    echo '</div>';
                echo '</div>';
            }
        ?>

        <div class="vacancy-item-button">
            <?php
                echo '<a href="' . esc_url(get_the_permalink()) . '" class="technum-button">';
                    esc_html_e('Details', 'technum');
                echo '</a>';
            ?>
        </div>
    </div>
</div>