<?php get_header()?>
  <main>
    <div class="container">
      <h1 class="category-title">
        <?php single_cat_title() ?>
      </h1>
      <div class="post-list">
        <?php while ( have_posts() ){ the_post(); ?>
          <a href="<?=get_permalink()?>" class="post-card">
            <img src="<?php if( has_post_thumbnail() ) the_post_thumbnail_url(null, 'thumbnail');
                else echo get_template_directory_uri().'/assets/images/img-default.png';
              ?>" alt="<?php the_title()?>"  class="post-card-thumb" />
            <div class="post-card-text">
              <h2 class="post-card-title"><?=mb_strimwidth(get_the_title(), 0, 50, '...')?></h2>
              <p><?=mb_strimwidth(get_the_excerpt(), 0, 90, '...')?></p>
              <div class="author">
                <?php $author_id = get_the_author_meta('ID'); ?>
                <img src="<?=get_avatar_url($author_id)?>" alt="<?php the_author()?>" class="author-avatar" />
                <div class="author-info">
                  <span class="author-name"><?=get_the_author()?></span>
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
                <!-- /.author-info -->
              </div>
              <!-- /.author -->
            </div>
          </a>
          <!-- /.post-card -->
        <?php } ?>
        <?php if ( ! have_posts() ){ ?>
          Записей нет.
        <?php } ?>
      </div>
      <!-- /.post-list -->
      <?php locate_template('pagination.php', true); ?>
    </div>
    <!-- /.container -->
  </main>
<?php get_footer()?>
