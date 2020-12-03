<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package universal-theme
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */

//Создаём свою функцию вывода каждого коммента
function universal_theme_comment( $comment, $args, $depth ) {
  //Проверяем в каком стиле у нас родитель (ol, ul или div)
	if ( 'div' === $args['style'] ) {
    //Если стиль - div, то тег будет div
		$tag       = 'div';
		$add_below = 'comment';
	} else {
    //В другом случае комментарий будет в теге li
		$tag       = 'li';
		$add_below = 'div-comment';
	}
  //Какие классы вешаем на каждый комментарий
	$classes = ' ' . comment_class( empty( $args['has_children'] ) ? '' : 'parent', null, null, false );
	?>

	<<?php echo $tag, $classes; ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) { ?>
		<div id="div-comment-<?php comment_ID() ?>" class="comment-body"><?php
	} ?>
      <div class="comment-author-avatar">
        <?php if ( $args['avatar_size'] != 0 ) {
          echo get_avatar( $comment, $args['avatar_size'] );
        } ?>
      </div>
      <!-- /.author-avatar -->
      <div class="comment-content">
        <div class="comment-author vcard">
          <?php
          printf(
            '<cite class="comment-author-name">%s</cite>',
            get_comment_author_link()
          );
          ?>
          <span class="comment-meta commentmetadata">
            <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
              <?php
              printf(
                __( '%1$s, %2$s' ),
                get_comment_date('F jS'),
                get_comment_time()
              ); ?>
            </a>

            <?php edit_comment_link( __( '(Edit)', 'universal' ), '  ', '' ); ?>
          </span>
        </div>

        <?php if ( $comment->comment_approved == '0' ) { ?>
          <em class="comment-awaiting-moderation">
            <?php _e( 'Your comment is awaiting moderation.', 'universal' ); ?>
          </em><br/>
        <?php } ?>

        <?php comment_text(); ?>

        <div class="comment-reply">
          <svg width="14" height="14" class="icon comments-add-icon">
            <use xlink:href="<?=get_template_directory_uri()?>/assets/images/sprite.svg#comment"></use>
          </svg>
          <?php
          comment_reply_link(
            array_merge(
              $args,
              array(
                'add_below' => $add_below,
                'depth'     => $depth,
                'max_depth' => $args['max_depth']
              )
            )
          ); ?>
        </div>
      </div>
      <!-- /.comment-content -->
	<?php if ( 'div' != $args['style'] ) { ?>
		</div>
	<?php }
}

if ( post_password_required() ) {
	return;
}
?>

<div class="container">
  <div id="comments" class="comments-area">

    <?php
    //Проверка есть ли комментарии
    if ( have_comments() ) :
      ?>
      <div class="comments-header">
        <h2 class="comments-title">
          <?php echo __('Comments', 'universal').' <span class="comments-count">'. get_comments_number() .'</span> ';?>
        </h2><!-- .comments-title -->
        <a href="#" class="comments-add-button">
          <svg width="18" height="18" class="icon comments-add-icon">
            <use xlink:href="<?=get_template_directory_uri()?>/assets/images/sprite.svg#pencil"></use>
          </svg>
          <?php _e('Add comment', 'universal') ?>
        </a>
      </div>
      <!-- /.comments-header -->
      
      <?php the_comments_navigation(); ?>
      <!-- Выводим список комментариев -->
      <ol class="comments-list">
        <?php
        //Выводим каждый отдельный комментарий
        wp_list_comments(
          array(
            'style'      => 'ol',
            'short_ping' => true,
            'avatar_size'=> 75,
            'callback' => 'universal_theme_comment',
            'login_text' => __('Register if you want to comment', 'universal'),
          )
        );
        ?>
      </ol><!-- .comments-list -->

      <?php
      the_comments_navigation();

      // If comments are closed and there are comments, let's leave a little note, shall we?
      if ( ! comments_open() ) :
        ?>
        <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'universal' ); ?></p>
        <?php
      endif;

    endif; // Check for have_comments().

    comment_form(array(
      'comment_field'         => '<div class="comment-form-comment">
        <label class="comment-label" for="comment">'._x( 'What do you think?', 'noun', 'universal' ) . '</label>
        <div class="comment-wrapper">
          '. get_avatar(get_current_user_id(), 75) .'
          <div class="comment-textarea-wrapper">
            <textarea id="comment" name="comment" aria-required="true" class="comment-textarea" ></textarea>
          </div>
          <!-- /.comment-textarea-wrapper -->
        </div>
      </div>',
      'must_log_in'           => '<p class="must-log-in">'.
        sprintf( __('You must be <a href="%s">logged in</a> to post a comment.', 'universal'), 
        wp_login_url( apply_filters('the_permalink', get_permalink()))) .'
      </p>',
      'logged_in_as'          => '',
      'comment_notes_before'  => '<p class="comment-notes">
        <span id="email-notes">' . __( 'Your email address will not be published.', 'universal' ) . '</span>'. 
        ( $req ? $required_text : '' ) . '
      </p>',
      'class_submit'          => 'comment-submit more',
      'label_submit'          => __('Send', 'universal'),
      'submit_button'         => '<button name="%1$s" type="submit" id="%2$s" class="%3$s">%4$s</button>',
      'title_reply'           => '',
    ));
    ?>

  </div><!-- #comments -->
</div>
<!-- /.container -->
