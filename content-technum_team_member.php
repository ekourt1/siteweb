<div <?php post_class('team-item-wrapper'); ?>>
    <div class="team-item">
        <a href="<?php the_permalink(); ?>" class="team-item-link">
            <?php
                echo '<span class="team-item-media">';
                    echo technum_team_member_media_output();
                echo '</span>';

                echo '<span class="team-item-content">';
                    if ( !empty(get_the_title()) ) {
                        echo '<span class="post-title">' . get_the_title() . '</span>';
                    }

                    if ( technum_post_options() && !empty(technum_get_post_option('team_member_position')) ) {
                        echo '<span class="team-item-position">';
                            echo esc_html(technum_get_post_option('team_member_position'));
                        echo '</span>';
                    }
                echo '</span>';
            ?>
        </a>
        <?php
            if ( technum_post_options() && !empty(technum_get_post_option('team_member_socials')) ) {
                echo '<div class="team-item-socials">';
                    $social_items = technum_get_post_option('team_member_socials');
                    echo '<ul class="team-socials wrapper-socials">';
                    foreach ( $social_items as $item ) {
                        echo '<li>';
                            echo '<a href="' . esc_url($item[1]) . '" target="_blank" class="fab ' . esc_attr($item[0]) . '"></a>';
                        echo '</li>';
                    }
                    echo '</ul>';
                echo '</div>';
            }
        ?>
    </div>
</div>