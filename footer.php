            <?php
                defined( 'ABSPATH' ) or die();

                if ( technum_get_prefered_option('footer_status') == 'on' ) {

                    $footer_classes = 'footer';
                    $footer_classes .= !empty(technum_get_prefered_option('footer_style')) ? ' footer-' . esc_attr(technum_get_prefered_option('footer_style')) : '';
                    ?>

                    <!-- Footer -->
                    <?php
                    echo '<footer class="' . esc_attr($footer_classes) . '">';
                        echo '<div class="footer-bg"></div>';
                        switch (technum_get_prefered_option('footer_style')) {
                            case 'type-2' :
                                get_template_part('templates/footer/footer-2');
                                break;
                            default :
                                get_template_part('templates/footer/footer-1');
                                break;
                        }
                    echo '</footer>';

                }
            ?>
        </div>
        <?php
            wp_footer();
        ?>
    </body>
</html>