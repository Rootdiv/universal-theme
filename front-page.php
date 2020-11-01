<?php get_header(); ?>
<main class="front-page-header">
  <div class="container">
    <div class="hero">
      <div class="left">
        <?php
        global $post;

        $myposts = get_posts([
          'numberposts' => 1,
          'category_name' => 'css, javascript, html, web-design',
        ]);

        if ($myposts) {
          foreach ($myposts as $post) {
            setup_postdata($post);
        ?>
        <!-- Выводим записи -->
        <img src="<?php if( has_post_thumbnail() ) the_post_thumbnail_url();
          else echo get_template_directory_uri().'/assets/images/img-default.png';
          ?>" alt="<?php the_title()?>" class="post-thumb" />
        <?php $author_id = get_the_author_meta('ID'); ?>
        <a href="<?=get_author_posts_url($author_id)?>" class="author">
          <img src="<?=get_avatar_url($author_id)?>" alt="<?=get_the_author()?>" class="avatar" />
          <div class="author-bio">
            <span class="author-name"><?=get_the_author()?></span>
            <span class="author-rank">Должность</span>
          </div>
        </a>
        <div class="post-text">
          <?php
          foreach (get_the_category() as $category) {
            printf(
              '<a href="%s" class="category-link">%s</a>',
              esc_url(get_category_link($category)),
              esc_html($category->name),
            );
          }?>
          <h2 class="post-title"><?=mb_strimwidth(get_the_title(), 0, 60, '...')?></h2>
          <a href="<?=get_the_permalink()?>" class="more">
            Читать далее
            <svg width="25" height="25" class="more-icon">
              <use xlink:href="<?=get_template_directory_uri()?>/assets/images/sprite.svg#arrow"></use>
            </svg>
          </a>
        </div>
        <?php }
        } else {
          ?> <p>Постов нет</p> <?php
        }
        wp_reset_postdata(); // Сбрасываем $post
        ?>
      </div>
      <!-- /.left -->
      <div class="right">
        <h3 class="recommend">Рекомендуем</h3>
        <ul class="posts-list">
          <?php
          global $post;

          $myposts = get_posts([
            'numberposts' => 5,
            'offset' => 1,
            'category_name' => 'css, javascript, html, web-design',
          ]);

          if ($myposts) {
            foreach ($myposts as $post) {
              setup_postdata($post);
          ?>
          <!-- Выводим записи -->
          <li class="post">
            <?php
            foreach (get_the_category() as $category) {
              printf(
                '<a href="%s" class="category-link %s">%s</a>',
                esc_url(get_category_link($category)),
                esc_html($category->slug),
                esc_html($category->name),
              );
            }?>
            <a class="post-permalink" href="<?=get_the_permalink()?>">
              <h4 class="post-title"><?= mb_strimwidth(get_the_title(), 0, 60, '...')?></h4>
            </a>
          </li>
          <?php }
          } else {
            ?> <p>Постов нет</p> <?php
          }
          wp_reset_postdata(); // Сбрасываем $post
          ?>
        </ul>
      </div>
      <!-- /.right -->
    </div>
    <!-- /.hero -->
  </div>
  <!-- /.container -->
</main>
<div class="container">
  <div class="article-space"></div>
  <ul class="article-list">
    <?php
    global $post;

    $myposts = get_posts([
      'numberposts' => 4,
      'category_name' => 'articles',
    ]);

    if ($myposts) {
      foreach ($myposts as $post) {
        setup_postdata($post);
    ?>
    <!-- Выводим записи -->
    <li class="article-item">
      <a class="article-permalink" href="<?=get_the_permalink()?>">
        <h4 class="article-title"><?= mb_strimwidth(get_the_title(), 0, 50, '...')?></h4>
      </a>
      <img width="65" height="65" src="<?php
        if( has_post_thumbnail() ) echo get_the_post_thumbnail_url(null, 'thumbnail');
        else echo get_template_directory_uri().'/assets/images/img-default.png';
      ?>" alt="<?php the_title()?>">
    </li>
    <?php }
    } else {
      ?> <p>Постов нет</p> <?php
    }
    wp_reset_postdata(); // Сбрасываем $post
    ?>
  </ul>
  <!-- /.article-list -->
  <div class="main-grid">
    <ul class="article-grid">
      <?php
      global $post;
      //Формируем запрос в БД
      $query = new WP_Query([
        //Получаем 7 постов
        'posts_per_page' => 7,
        'category__not_in' => 30,
      ]);
      //Проверяем есть ли посты    
      if ($query->have_posts()) {
        //Создаём переменную-счётчик постов
        $cnt = 0;
        //Пока посты есть, выводим их
        while ($query->have_posts()) {
          $query->the_post();
          //Увеличиваем счётчик постов
          $cnt++;
          switch ($cnt) {
            //Выводим первый пост
            case '1': ?>
      <li class="article-grid-item article-grid-item-1">
        <a href="<?=get_permalink()?>" class="article-grid-permalink">
          <img src=<?php if( has_post_thumbnail() ) the_post_thumbnail_url();
            else echo get_template_directory_uri().'/assets/images/img-default.png';
          ?>" alt="<?php the_title()?>" class="article-grid-thumb" />
          <span class="category-name"><?php $category = get_the_category(); echo $category[0]->name; ?></span>
          <h4 class="article-grid-title"><?= mb_strimwidth(get_the_title(), 0, 50, '...')?></h4>
          <p class="article-grid-excerpt"><?= mb_strimwidth(get_the_excerpt(), 0, 100, '...')?></p>
          <div class="article-grid-info">
            <div class="author">
              <?php $author_id = get_the_author_meta('ID'); ?>
              <img src="<?=get_avatar_url($author_id)?>" alt="<?php the_author()?>" class="author-avatar" />
              <span class="author-name"><strong><?=get_the_author()?></strong>:
                <?php the_author_meta('description')?></span>
            </div>
            <div class="comments">
              <svg width="14" height="14" class="comments-icon">
                <use xlink:href="<?=get_template_directory_uri()?>/assets/images/sprite.svg#comment"></use>
              </svg>
              <span class="comments-counter"><?php comments_number('0', '1', '%')?></span>
            </div>
          </div>
        </a>
      </li>
      <?php
            break;
            //Выводим второй пост
            case '2': ?>
      <li class="article-grid-item article-grid-item-2">
        <img src="<?php if( has_post_thumbnail() ) the_post_thumbnail_url();
          else echo get_template_directory_uri().'/assets/images/img-default.png';
        ?>" alt="<?php the_title()?>" class="article-grid-thumb" />
        <a href="<?=get_permalink()?>" class="article-grid-permalink">
          <span class="tag"><?php $posttags = get_the_tags();
            if ($posttags) echo $posttags[0]->name . ' '; ?></span>
          <span class="category-name"><?php $category = get_the_category(); echo $category[0]->name; ?></span>
          <h4 class="article-grid-title"><?= mb_strimwidth(get_the_title(), 0, 50, '...')?></h4>
          <div class="article-grid-info">
            <div class="author">
              <?php $author_id = get_the_author_meta('ID'); ?>
              <img src="<?=get_avatar_url($author_id)?>" alt="<?php the_author()?>" class="author-avatar" />
              <div class="author-info">
                <span class="author-name"><?=get_the_author()?></span>
                <span class="date"><?php the_time('j F')?></span>
                <div class="comments">
                  <svg width="14" height="14" fill="#ffffff" class="comments-icon">
                    <use xlink:href="<?=get_template_directory_uri()?>/assets/images/sprite.svg#comment"></use>
                  </svg>
                  <span class="comments-counter"><?php comments_number('0', '1', '%')?></span>
                </div>
                <div class="likes">
                  <svg width="14" height="14" class="likes-icon">
                    <use xlink:href="<?=get_template_directory_uri()?>/assets/images/sprite.svg#like"></use>
                  </svg>
                  <span class="likes-counter"><?php comments_number('0', '1', '%')?></span>
                </div>
              </div>
              <!-- /.author-info -->
            </div>
          </div>
        </a>
      </li>
      <?php
            break;
            //Выводим третий пост
            case '3': ?>
      <li class="article-grid-item article-grid-item-3">
        <img src="<?php if( has_post_thumbnail() )the_post_thumbnail_url();
          else echo get_template_directory_uri().'/assets/images/img-default.png';
        ?>" alt="<?php the_title()?>" class="article-grid-thumb" />
        <a href="<?=get_permalink()?>" class="article-grid-permalink">
          <h4 class="article-grid-title"><?php the_title()?></h4>
        </a>
      </li>
      <?php
      break;
      //Выводим остальные посты
      default: ?>
      <li class="article-grid-item article-grid-item-default">
        <a href="<?=get_permalink()?>" class="article-grid-permalink">
          <h4 class="article-grid-title"><?= mb_strimwidth(get_the_title(), 0, 23, '...')?></h4>
          <p class="article-grid-excerpt"><?= mb_strimwidth(get_the_excerpt(), 0, 70, '...')?></p>
          <span class="date"><?php the_time('j F')?></span>
        </a>
      </li>
      <?php
            break;
          }
        }
      } else {
        ?> <p>Постов нет</p> <?php
      }
      wp_reset_postdata(); // Сбрасываем $post
      ?>
    </ul>
    <!-- /.article-grid -->
    <!-- Подключаем верхний сайдбар -->
    <?php get_sidebar('home-top')?>
  </div>
</div>
<!-- /.container -->
<?php
global $post;
//Пост с большим фоном
$query = new WP_Query([
  'posts_per_page' => 1,
  'category_name' => 'investigation',
]);

if ($query->have_posts()) {
  while ($query->have_posts()) {
    $query->the_post();
?>
<section class="investigation"
  style="background: linear-gradient(0deg, rgba(64, 48, 61, 0.35), rgba(64, 48, 61, 0.35)), url('<?php
    if( has_post_thumbnail() ) the_post_thumbnail_url();
    else echo get_template_directory_uri().'/assets/images/img-default.png';
  ?>') no-repeat center center">
  <div class="container">
    <h2 class="investigation-title"><?php the_title()?></h2>
    <a href="<?=get_the_permalink()?>" class="more">
      Читать статью
      <svg width="25" height="25" class="more-icon">
        <use xlink:href="<?=get_template_directory_uri()?>/assets/images/sprite.svg#arrow"></use>
      </svg>
    </a>
  </div>
</section>
<!-- /.investigation -->
<?php
  }
} else {
  ?> <p>Постов нет</p> <?php
}

wp_reset_postdata(); // Сбрасываем $post
?>
<div class="container">
  <div class="main-post-list">
    <ul class="digest">
      <?php
      global $post;
      //Формируем запрос в БД
      $query = new WP_Query([
        //Получаем 6 постов
        'posts_per_page' => 6,
        'category__not_in' => 49,
      ]);
      //Проверяем есть ли посты    
      if ($query->have_posts()) {
        //Пока посты есть, выводим их
        while ($query->have_posts()) {
          $query->the_post();
      ?>
      <li class="digest-item">
        <a href="<?=get_the_permalink()?>" class="digest-item-permalink">
          <img src="<?php if( has_post_thumbnail() ) the_post_thumbnail_url();
            else echo get_template_directory_uri().'/assets/images/img-default.png';
          ?>" alt="<?php the_title()?>" class="digest-thumb" />
        </a>
        <div class="digest-info">
          <button class="bookmark">
            <svg width="14" height="18" class="bookmark-icon">
              <use xlink:href="<?=get_template_directory_uri()?>/assets/images/sprite.svg#bookmark"></use>
            </svg>
          </button>
          <?php 
          foreach (get_the_category() as $category) {
            printf(
              '<a href="%s" class="category-link %s">%s</a>',
              esc_url(get_category_link($category)),
              esc_html($category->slug),
              esc_html($category->name),
            );
          }?>
          <a href="<?=get_the_permalink()?>" class="digest-item-permalink">
            <h3 class="digest-title"><?= mb_strimwidth(get_the_title(), 0, 65, '...')?></h3>
          </a>
          <p class="digest-excerpt"><?= mb_strimwidth(get_the_excerpt(), 0, 150, '...')?></p>
          <div class="article-info">
            <span class="date"><?php the_time('j F')?></span>
            <div class="comments">
              <svg width="14" height="14" class="comments-icon">
                <use xlink:href="<?=get_template_directory_uri()?>/assets/images/sprite.svg#comment"></use>
              </svg>
              <span class="comments-counter"><?php comments_number('0', '1', '%')?></span>
            </div>
            <div class="likes">
              <svg width="14" height="14" class="likes-icon">
                <use xlink:href="<?=get_template_directory_uri()?>/assets/images/sprite.svg#like"></use>
              </svg>
              <span class="likes-counter"><?php comments_number('0', '1', '%')?></span>
            </div>
          </div>
        </div>
      </li>
      <?php
        }
      } else {
        ?> <p>Постов нет</p> <?php
      }
      wp_reset_postdata(); // Сбрасываем $post
      ?>
    </ul>
    <!-- /.digest -->
    <!-- Подключаем верхний сайдбар -->
    <?php get_sidebar('home-bottom')?>
  </div>
</div>
<!-- /.container -->
<div class="special">
  <div class="container">
    <div class="special-grid">
      <?php
      global $post;
      //Формируем запрос в БД
      $query = new WP_Query([
        'posts_per_page' => 1,
        'category_name' => 'photo-report',
      ]);
      //Проверяем есть ли посты    
      if ($query->have_posts()) {
        //Пока посты есть, выводим их
        while ($query->have_posts()) {
          $query->the_post();
          ?>
        <div class="photo-report">
          <!-- Slider main container -->
          <div class="swiper-container photo-report-slider">
              <!-- Additional required wrapper -->
              <div class="swiper-wrapper">
                <!-- Slides -->
                <?php $images = get_attached_media('image');
                foreach($images as $image){
                  echo '<div class="swiper-slide"><img src="';
                  print_r($image->guid);
                  echo '" alt="Слайдер" /></div>';
                }?>
              </div>
              <div class="swiper-pagination"></div>
          </div>
          <div class="photo-report-content">
            <?php
            foreach (get_the_category() as $category) {
              printf(
                '<a href="%s" class="category-link">%s</a>',
                esc_url(get_category_link($category)),
                esc_html($category->name),
              );
            }
            $author_id = get_the_author_meta('ID'); ?>
            <a href="<?=get_author_posts_url($author_id)?>" class="author">
              <img src="<?=get_avatar_url($author_id)?>" alt="<?=get_the_author()?>" class="author-avatar" />
              <div class="author-bio">
                <span class="author-name"><?=get_the_author()?></span>
                <span class="author-rank">Должность</span>
              </div>
            </a>
            <h3 class="photo-report-title"><?php the_title()?></h3>
            <a href="<?=get_the_permalink()?>" class="button photo-report-button">
              <svg width="19" height="15" class="icon photo-report-icon">
                <use xlink:href="<?=get_template_directory_uri()?>/assets/images/sprite.svg#images"></use>
              </svg>
              Смотреть фото
              <span class="photo-report-counter"><?=count($images)?></span>
            </a>
          </div>
          <!-- /.photo-report-content -->
        </div>
        <?php
        }
      } else {
        ?> <p>Постов нет</p> <?php
      }
      wp_reset_postdata(); // Сбрасываем $post
      ?>
      <!-- /.photo-report -->
      <div class="other">
        <div class="career">
          <?php
            global $post;

            $myposts = get_posts([
              'numberposts' => 1,
              'category_name' => 'career',
            ]);

            if ($myposts) {
              foreach ($myposts as $post) {
                setup_postdata($post);
                foreach (get_the_category() as $category) {
                  printf(
                    '<a href="%s" class="category-link">%s</a>',
                    esc_url(get_category_link($category)),
                    esc_html($category->name),
                  );
                }?>
          <div class="career-post">
            <h2 class="career-post-title"><?php the_title()?></h2>
            <p class="career-post-excerpt"><?= mb_strimwidth(get_the_excerpt(), 0, 85, '...')?></p>
            <a href="<?=get_the_permalink()?>" class="more">
              Читать далее
              <svg width="25" height="25" class="more-icon">
                <use xlink:href="<?=get_template_directory_uri()?>/assets/images/sprite.svg#arrow"></use>
              </svg>
            </a>
          </div>
          <?php
              }
            } else {
              ?> <p>Постов нет</p> <?php
            }
            wp_reset_postdata(); // Сбрасываем $post
          ?>
        </div>
        <!-- /.career -->
        <div class="other-posts">
          <?php
            global $post;

            $myposts = get_posts([
              'numberposts' => 2,
            ]);

            if ($myposts) {
              foreach ($myposts as $post) {
                setup_postdata($post);?>
          <div class="other-posts-content">
            <a href="<?=get_permalink()?>" class="other-posts-permalink">
              <h4 class="other-posts-title"><?= mb_strimwidth(get_the_title(), 0, 23, '...')?></h4>
              <p class="other-posts-excerpt"><?= mb_strimwidth(get_the_excerpt(), 0, 70, '...')?></p>
              <span class="date"><?php the_time('j F')?></span>
            </a>
          </div>
          <?php
              }
            } else {
              ?> <p>Постов нет</p> <?php
            }
            wp_reset_postdata(); // Сбрасываем $post
          ?>
        </div>
        <!-- /.other-posts -->
      </div>
      <!-- /.other -->
    </div>
    <!-- /.specila-grid -->
  </div>
  <!-- /.container -->
</div>
<!-- /.special -->
<?php get_footer(); ?>
