<?php
/*
 * Created by Artureanec
*/

if (post_password_required()) {
    return;
}

if ( ! function_exists( 'technum_comment_code' ) ) {
    function technum_comment_code($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        ?>

        <div <?php comment_class('post-comment-wrapper'); ?> id="comment-<?php comment_ID() ?>">
            <div class="post-comment-item">
                <?php
                    if( $args['avatar_size'] != 0 ){
                        echo '<div class="post-comment-avatar">';
                            echo get_avatar($comment, $args['avatar_size']);
                        echo '</div>';
                    }
                ?>

                <div class="post-comment-main">
                    <?php
                    if ($comment->comment_approved == '0') {
                        echo '<p>' . esc_html__('Your comment is awaiting moderation.', 'technum') . '</p>';
                    }

                    echo '
                        <div class="post-comment-meta">
                            <div class="post-comment-info">
                                <div class="post-comment-author">' . esc_html(get_comment_author()) . '</div>';
                                ?>
                                <div class="post-comment-date"><?php esc_html(comment_date()); ?></div>
                            </div>
                            <div class="post-comment-buttons">
                                <?php
                                    comment_reply_link(
                                        array_merge(
                                            $args, array(
                                                'before'        => '',
                                                'after'         => '',
                                                'depth'         => $depth,
                                                'reply_text'    => esc_html__('Reply', 'technum'),
                                                'max_depth'     => $args['max_depth']
                                            )
                                        )
                                    );
                                    edit_comment_link(esc_html__('Edit', 'technum'));
                                ?>
                            </div>
                            <?php
                            echo '
                        </div>
                    ';
                    ?>
                    <div class="post-comment-content">
                        <?php comment_text(); ?>
                    </div>
                </div>
            </div>
        <?php
    }
}

if ( have_comments() || comments_open() || pings_open() ) {
    ?>
        <div class="post-comments-wrapper">
            <?php
            if (have_comments()) {
                $comments_number = number_format_i18n( get_comments_number() );
                ?>

                <h3 class="post-comments-title">
                    <?php
                        echo esc_html(_n( 'Comment', 'Comments', $comments_number, 'technum')) . ' <span class="post-comments-title-counter">(' . esc_html($comments_number) . ')</span>';
                    ?>
                </h3>

                <div class="post-comments-list">
                    <?php
                    wp_list_comments(array(
                        'style'         => 'div',
                        'avatar_size'   => 90,
                        'type'          => 'all',
                        'callback'      => 'technum_comment_code'
                    ));
                    ?>
                </div>

                <?php the_comments_navigation();
            }

            $commenter = wp_get_current_commenter();
            $consent = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';
            $comment_form_args = array(
                'title_reply'           => esc_html__('Leave a Comment', 'technum'),
                'cancel_reply_link'     => esc_html__('(Cancel reply)', 'technum'),
                'title_reply_to'        => esc_html__('Leave a Reply to %s', 'technum'),
                'title_reply_before'    => '<h3 id="reply-title" class="comment-reply-title">',
                'title_reply_after'     => '</h3>',
                'fields'                => array(
                    'author'    => '<div class="form-fields"><input class="form-field form-name" placeholder="'.esc_attr__('Your Name *', 'technum').'" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" />',
                    'email'     => '<input class="form-field form-email" placeholder="' . esc_attr__('Your Email *', 'technum') . '" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" />',
                    'url'       => '<input class="form-field form-url" placeholder="' . esc_attr__('Your Website', 'technum') . '" name="url" type="text" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" />',
                    'cookies'   => '<div class="form-field form-cookies comment-form-cookies-consent">'.
                                         sprintf( '<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"%s />', $consent ) . '
                                         <label for="wp-comment-cookies-consent">' . esc_html__( 'Save my name, email, and website in this browser for the next time I comment.', 'technum' ) . '</label>
                                    </div></div>',
                ),
                'comment_field'         => '<textarea name="comment" cols="45" rows="6" placeholder="' . esc_attr__('Comment...', 'technum') . '" id="comment-message" class="form-field form-message"></textarea>',
                'label_submit'          => esc_html__('Post Comment', 'technum'),
                'logged_in_as'          => '<p><a class="logged-in-as">' . esc_html__('Logged in as ', 'technum') . '<a href="' . esc_url(admin_url( 'profile.php' )) . '">' . esc_html(wp_get_current_user()->display_name) . '</a>. ' . '<a href="' . wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) ) . '">' . esc_html__('Log out?', 'technum') . '</a>' . '</p>',
                'submit_button'         => '<button name="%1$s" id="%2$s" class="%3$s">%4$s</button>',
                'submit_field'          => '%1$s %2$s'
            );
            comment_form($comment_form_args);
            ?>
        </div>

    <?php
}