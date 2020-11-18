<?php get_header();?>
<main class="search">
  <div class="container">
    <h1 class="search-title">Результаты поиска по запросу:</h1>
    <div class="favorites">
      <div class="digest-wrapper">
        <ul class="digest">
          <?php while ( have_posts() ){ the_post(); ?>
          <li class="digest-item">
            <a href="<?=get_the_permalink()?>" class="digest-item-permalink">
              <img src="<?php if( has_post_thumbnail() ) the_post_thumbnail_url();
                else echo get_template_directory_uri().'/assets/images/img-default.png';
              ?>" alt="<?php the_title()?>" class="digest-thumb" />
            </a>
            <div class="digest-info">
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
          <?php } ?>
          <?php if ( ! have_posts() ){ ?>
            Записей нет.
          <?php } ?>
        </ul>
        <!-- /.digest -->
        <?php require_once 'pagination.php';?>
      </div>
      <!-- /.digest-wrapper -->
      <!-- Подключаем нижний сайдбар -->
      <?php get_sidebar('home-bottom')?>
    </div>
    <!-- ./main-post-list -->
  </div>
  <!-- /.container -->
</main>
<?php get_footer();?>
