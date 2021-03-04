<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <!-- Шапка поста -->
  <header class="entry-header <?=get_post_type()?>-header" style="background: linear-gradient(0deg, rgba(38, 45, 51, 0.75), rgba(38, 45, 51, 0.75));">
		<div class="container">
      <div class="post-header-wrapper">
        <div class="post-header-nav">
          <?php foreach (get_the_category() as $category) {
            printf(
              '<a href="%s" class="category-link %s">%s</a>',
              esc_url(get_category_link($category)),
              esc_html($category->slug),
              esc_html($category->name)
            );
          }?>
        </div>
        <div class="video">
          <?php $video = get_field('video_link');
            if(stristr($video, 'youtube')){
              $link = explode('?v=', $video);
              $video_link = end($link);
              echo '<iframe width="100%" height="450" src="https://www.youtube.com/embed/'.$video_link.'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
            }elseif(stristr($video, 'youtu')){
              $link = explode('/', $video);
              $video_link = end($link);
              echo '<iframe width="100%" height="450" src="https://www.youtube.com/embed/'.$video_link.'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
            }elseif(stristr($video, 'vimeo')){
              $link = explode('/', $video);
              $video_link = end($link); 
              echo '<iframe src="https://player.vimeo.com/video/'.$video_link.'" width="100%" height="450" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>';
            }
          ?>
        </div>
        <!-- /.post-header-nav -->
        <div class="lesson-header">
          <div class="lesson-header-title-wrapper">
            <?php //Проверяем точно ли мы на странице поста
            if ( is_singular() ) :
              the_title( '<h1 class="lesson-header-title">', '</h1>' );
            else :
              the_title( '<h2 class="lesson-header-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
            endif;?>
          </div>
        </div>
        <div class="post-header-info">
          <div class="post-header-date">
            <svg width="14" height="14" class="icon clocks-icon">
              <use xlink:href="<?=get_template_directory_uri()?>/assets/images/sprite.svg#clock"></use>
            </svg>
            <span><?php the_time('j F, G:i')?></span>
          </div>
        </div>
        <!-- /.post-header-info -->
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
          'after'  => '</div>'
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
      <?php //get_sidebar('articles') ?>
    </div>
    <!-- /.container -->
  </div>
  <!-- /.sidebar-post -->
</article>
