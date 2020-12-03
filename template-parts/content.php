<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <!-- Шапка поста -->
  <header class="entry-header <?=get_post_type()?>-header" style="background: linear-gradient(0deg, rgba(38, 45, 51, 0.75), rgba(38, 45, 51, 0.75)), url(
    <?php if( has_post_thumbnail() ) the_post_thumbnail_url();
      else echo get_template_directory_uri().'/assets/images/img-default.png';
    ?>);">
		<div class="container">
      <div class="post-header-wrapper">
        <div class="post-header-nav">
          <?php foreach (get_the_category() as $category) {
            printf(
              '<a href="%s" class="category-link %s">%s</a>',
              esc_url(get_category_link($category)),
              esc_html($category->slug),
              esc_html($category->name),
            );
          }?>
          <!-- Ссылка на главную -->
          <a href="<?=get_home_url()?>" class="home-link" >
            <svg width="18" height="17" class="icon home-icon">
              <use xlink:href="<?=get_template_directory_uri()?>/assets/images/sprite.svg#home"></use>
            </svg>
            <?php _e('On the main') ?>
          </a>
          <?php //Выводим ссылки на предыдущий и следующий пост
          the_post_navigation(
            array(
              'prev_text' => '<span class="post-nav-prev">
                <svg width="15" height="7" class="prev-icon">
                  <use xlink:href="'. get_template_directory_uri() .'/assets/images/sprite.svg#arrow"></use>
                </svg>
              ' . esc_html__( 'Back', 'universal' ) . '</span>',
              'next_text' => '<span class="post-nav-next">' . esc_html__( 'Forward', 'universal' ) . '
                <svg width="15" height="7" class="prev-icon">
                  <use xlink:href="'. get_template_directory_uri() .'/assets/images/sprite.svg#arrow"></use>
                </svg>
              </span>',
            )
          );?>
        </div>
        <!-- /.post-header-nav -->
        <div class="post-header">
          <div class="post-header-title-wrapper">
            <?php //Проверяем точно ли мы на странице поста
            if ( is_singular() ) :
              the_title( '<h1 class="post-header-title">', '</h1>' );
            else :
              the_title( '<h2 class="post-header-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
            endif;?>
            <button class="bookmark">
              <svg width="21" height="27" class="bookmark-icon">
                <use xlink:href="<?=get_template_directory_uri()?>/assets/images/sprite.svg#bookmark"></use>
              </svg>
            </button>
          </div>
          <?php the_excerpt() ?>
        </div>
        <div class="post-header-info">
          <div class="post-header-date">
            <svg width="14" height="14" class="icon clocks-icon">
              <use xlink:href="<?=get_template_directory_uri()?>/assets/images/sprite.svg#clock"></use>
            </svg>
            <span><?php the_time('j F, G:i')?></span>
          </div>
          <div class="comments post-header-comments">
            <svg width="14" height="14" class="icon comments-icon">
              <use xlink:href="<?=get_template_directory_uri()?>/assets/images/sprite.svg#comment"></use>
            </svg>
            <span class="comments-counter"><?php comments_number('0', '1', '%')?></span>
          </div>
          <div class="likes post-header-likes">
            <svg width="14" height="14" class="likes-icon">
              <use xlink:href="<?=get_template_directory_uri()?>/assets/images/sprite.svg#like"></use>
            </svg>
            <span class="likes-counter"><?php comments_number('0', '1', '%')?></span>
          </div>
        </div>
        <!-- /.post-header-info -->
        <div class="post-author">
          <div class="post-author-info">
            <?php $author_id = get_the_author_meta('ID'); ?>
            <img src="<?=get_avatar_url($author_id)?>" alt="<?=get_the_author()?>" class="post-author-avatar" />
            <span class="post-author-name"><?=get_the_author()?></span>
            <span class="post-author-rank"><?php _e('Rank', 'universal') ?></span>
            <span class="post-author-posts">
              <?php plural_form(count_user_posts($author_id),
                /* варианты написания для количества 1, 2 и 5 */
                array('статья', 'статьи', 'статей'));?>
            </span>
          </div>
          <!-- /.post-author-info -->
          <a href="<?=get_author_posts_url($author_id)?>" class="post-author-link"><?php _e('Page author', 'universal') ?></a>
        </div>
        <!-- /.post-author -->
      </div>
      <!-- /.post-header-wrapper -->
    </div>
	</header><!-- /Шапка поста -->
  <div class="container">
    <!-- Содержимое поста -->
    <div class="post-content">
      <?php //Содержимое поста
      the_content(
        sprintf(
          wp_kses(
            /* translators: %s: Name of current post. Only visible to screen readers */
            __( 'Continue reading <span class="screen-reader-text">"%s"</span>', 'universal' ),
            array(
              'span' => array(
                'class' => array(),
              ),
            )
          ),
          wp_kses_post( get_the_title() )
        )
      );

      wp_link_pages(
        array(
          'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'universal' ),
          'after'  => '</div>',
        )
      );?>
    </div><!-- /Содержимое поста -->
    <!-- Подвал поста-->
    <footer class="entry-footer">
      <?php $tags_list = get_the_tag_list( '', esc_html_x( '', 'list item separator', 'universal' ) );
        if ( $tags_list ) {
          //Список тегов
          printf( '<span class="tags-links">' . esc_html( '%1$s' ) . '</span>', $tags_list );
        } 
        //Поделится в соцсетях
        meks_ess_share();
      ?>
    </footer><!-- /Подвал поста-->
  </div>
  <!-- /.container -->
  <div class="sidebar-post">
    <div class="container">
      <!-- Подключаем сайдбар -->
      <?php get_sidebar('articles') ?>
    </div>
    <!-- /.container -->
  </div>
  <!-- /.sidebar-post -->
</article>
