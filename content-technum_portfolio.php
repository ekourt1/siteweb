<?php
    $columns_number = !empty($args['columns_number']) ? $args['columns_number'] : technum_get_theme_mod('portfolio_archive_columns_number');
    $item_class     = !empty($args['item_class']) ? $args['item_class'] : 'portfolio-item-wrapper';
    $type           = !empty($args['listing_type']) ? $args['listing_type'] : 'grid';
?>

<div <?php post_class($item_class); ?>>
    <div class="portfolio-item">
        <a href="<?php the_permalink(); ?>" class="portfolio-item-link">
            <?php
                echo '<span class="portfolio-item-media">';
                    echo technum_portfolio_grid_media_output(null, $columns_number, $type);
                echo '</span>';
                if ( !empty(get_the_title()) ) {
                    echo '<span class="portfolio-item-content">';
                        echo '<span class="post-title">' . get_the_title() . '</span>';
                    echo '</span>';
                }
            ?>
        </a>
    </div>
</div>