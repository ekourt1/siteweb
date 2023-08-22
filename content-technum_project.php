<?php
    $columns_number = !empty($args['columns_number']) ? $args['columns_number'] : technum_get_theme_mod('project_archive_columns_number');
    $item_class     = !empty($args['item_class']) ? $args['item_class'] : 'project-item-wrapper';
    $text_position  = !empty($args['text_position']) ? $args['text_position'] : 'outside';
?>

<div <?php post_class($item_class); ?>>
    <div class="project-item">
        <a href="<?php the_permalink(); ?>" class="project-item-link">
            <?php
                echo '<span class="project-item-media tilt-effect">';
                    echo technum_portfolio_grid_media_output(null, $columns_number, false);
                echo '</span>';

                if ( $text_position == 'inside' ) {
                    echo '<span class="project-item-content">';
                        if ( !empty(get_the_title()) ) {
                            echo '<span class="post-title">' . get_the_title() . '</span>';
                        }
                        if ( !empty(technum_taxonomy_output('technum_project_category')) ) {
                            echo '<span class="project-item-categories">';
                                echo technum_taxonomy_output('technum_project_category', ' / ', false);
                            echo '</span>';
                        }
                    echo '</span>';
                }
            ?>
        </a>
        <?php
            if ( $text_position == 'outside' ) {
                echo '<div class="project-item-content">';
                    if (!empty(get_the_title())) {
                        echo '<div class="post-title"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></div>';
                    }
                    if ( !empty(technum_taxonomy_output('technum_project_category')) ) {
                        echo '<div class="project-item-categories">';
                            echo technum_taxonomy_output('technum_project_category', ' / ', true);
                        echo '</div>';
                    }
                echo '</div>';
            }
        ?>
    </div>
</div>