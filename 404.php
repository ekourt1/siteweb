<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php wp_head(); ?>
</head>

<!-- Body -->
<body <?php body_class(); ?>>

    <div class="error-404-container">

        <div class="error-404-header">
            <!-- Logo Block -->
            <?php
                if ( technum_get_prefered_option('error_logo_status') == 'on' ) {
                    echo '<div class="logo-container">' . technum_get_logo_output() . '</div>';
                }
            ?>
        </div>

        <?php
            if ( !empty(technum_get_theme_mod('error_main_image')) ) {
                echo '<img src="' . esc_url(technum_get_theme_mod('error_main_image')) . '" alt="' . esc_attr__('404', 'technum') . '" class="error-404-image tilt-effect">';
            }
        ?>

        <div class="error-404-inner">
            <div class="error-404-content">
                <?php
                    if ( !empty(technum_get_theme_mod('error_title')) ) {
                        echo '<h1 class="error-404-title">' . wp_kses(technum_get_theme_mod('error_title'), array('br' => array())) . '</h1>';
                    }
                    if ( !empty(technum_get_theme_mod('error_text')) ) {
                        echo '<p class="error-404-info-text">' . esc_html(technum_get_theme_mod('error_text')) . '</p>';
                    }
                    if ( !empty(technum_get_theme_mod('error_button_text')) ) {
                        echo '<div class="error-404-button">';
                            echo '<a class="error-404-home-button technum-button" href="' . esc_url(home_url('/')) . '">' . esc_html(technum_get_theme_mod('error_button_text')) . '</a>';
                        echo '</div>';
                    }
                ?>
            </div>
        </div>

    </div>

<?php
    wp_footer();
?>
</body>
</html>