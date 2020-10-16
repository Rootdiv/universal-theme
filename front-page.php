<?php get_header(); ?>
<main class="fron-page-header">
    <div class="container">
        <div class="hero">
            <div class="left">
                <?php
                global $post;

                $myposts = get_posts([ 
                    'numberposts' => 1,
                    'category_name' => 'css, javascript, html, web-design',
                ]);

                if( $myposts ){
                    foreach( $myposts as $post ){
                        setup_postdata( $post );
                        ?>
                        <!-- Выводим записи -->
                <img src="<?php the_post_thumbnail_url(); ?>" alt="<?=the_title()?>" class="post-thumb" />
                <?php $author_id = get_the_author_meta('ID'); ?>
                <a href="<?=get_author_posts_url($author_id)?>" class="author">
                    <img src="<?=get_avatar_url($author_id)?>" alt="<?=get_the_author()?>" class="avatar" />
                    <div class="author-bio">
                        <span class="author-name"><?=get_the_author()?></span>
                        <span class="author-rank">Должность</span>
                    </div>
                </a>
                <div class="post-text">
                    <?php the_category(); ?>
                    <h2 class="post-title"><?=mb_strimwidth(get_the_title(), 0, 60, '...')?></h2>
                    <a href="<?=get_the_permalink()?>" class="more">Читать далее</a>
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

                    if( $myposts ){
                        foreach( $myposts as $post ){
                            setup_postdata( $post );
                            ?>
                            <!-- Выводим записи -->
                    <li class="post">
                        <?php the_category(); ?>
                        <a class="post-permalink" href="<?=get_the_permalink()?>">
                            <h4 class="post-title"><?=mb_strimwidth(get_the_title(), 0, 60, '...')?></h4>
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
    <ul class="article-list">
        <?php
        global $post;

        $myposts = get_posts([ 
            'numberposts' => 4,
            'category_name' => 'articles',
        ]);

        if( $myposts ){
            foreach( $myposts as $post ){
        setup_postdata( $post );
        ?>
        <!-- Выводим записи -->
        <li class="article-item">
            <a class="article-permalink" href="<?=get_the_permalink()?>">
                <h4 class="article-title"><?=mb_strimwidth(get_the_title(), 0, 50, '...')?></h4>
            </a>
            <img width="65" height="65" src="<?=get_the_post_thumbnail_url(null, 'thumbnail')?>" alt="<?php the_title()?>">
        </li>
        <?php }
        } else {
            ?> <p>Постов нет</p> <?php
        }
        wp_reset_postdata(); // Сбрасываем $post
        ?>
    </ul>
    <!-- /.article-list -->
    <ul class="article-grid">
        <?php		
        global $post;
        //Формируем запрос в БД
        $query = new WP_Query( [
            //Получаем 7 постов
            'posts_per_page' => 7,
        ] );
        //Проверяем есть ли посты    
        if ( $query->have_posts() ) {
            //Создаём переменную-счётчик постов
            $cnt = 0;
            //Пока посты есть, выводим их
            while ( $query->have_posts() ) {
                $query->the_post();
                //Увеличиваем счётчик постов
                $cnt++;
                switch ($cnt) {
                    //Выводим первый пост
                    case '1': ?>
                        <li class="article-grid-item article-grid-item-1">
                            <a href="<?=get_permalink()?>" class="article-grid-permalink">
                                <img src="<?php the_post_thumbnail_url(); ?>" alt="<?=the_title()?>" class="article-grid-thumb" />
                                <span class="category-name"><?php $category = get_the_category();
                                echo $category[0]->name; ?></span>
                                <h4 class="article-grid-title"><?=mb_strimwidth(get_the_title(), 0, 50, '...')?></h4>
                                <p class="article-grid-excerpt"><?=mb_strimwidth(get_the_excerpt(), 0, 100, '...')?></p>
                                <div class="article-grid-info">
                                    <div class="author">
                                        <?php $author_id = get_the_author_meta('ID'); ?>
                                        <img src="<?=get_avatar_url($author_id)?>" alt="<?=get_the_author()?>" class="author-avatar" />
                                        <span class="author-name"><strong><?=get_the_author()?></strong>: <?php the_author_meta('description') ?></span>
                                    </div>
                                    <div class="comments">
                                        <img src="<?=get_template_directory_uri() . '/assets/images/comment.svg';?>" alt="icon: comment" class="comments-icon">
                                        <span class="comments-counter"><?php comments_number('0', '1', '%') ?></span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <?php
                        break;
                    //Выводим второй пост
                    case '2': ?>
                        <li class="article-grid-item article-grid-item-2">
                            <img src="<?php the_post_thumbnail_url(); ?>" alt="<?=the_title()?>" class="article-grid-thumb" />
                            <a href="<?=get_permalink()?>" class="article-grid-permalink">
                                <span class="tag"><?php $posttags = get_the_tags();
                                if($posttags) echo $posttags[3]->name . ' '; ?></span>
                                <span class="category-name"><?php $category = get_the_category();
                                echo $category[0]->name; ?></span>
                                <h4 class="article-grid-title"><?=mb_strimwidth(get_the_title(), 0, 50, '...')?></h4>
                                <div class="article-grid-info">
                                    <div class="author">
                                        <?php $author_id = get_the_author_meta('ID'); ?>
                                        <img src="<?=get_avatar_url($author_id)?>" alt="<?=get_the_author()?>" class="author-avatar" />
                                        <div class="author-info">
                                            <span class="author-name"><?=get_the_author()?></span>
                                            <span class="date"><?php the_time('j F') ?></span>
                                            <div class="comments">
                                                <img src="<?=get_template_directory_uri() . '/assets/images/comment-white.svg';?>"
                                                alt="icon: comment" class="comments-icon">
                                                <span class="comments-counter"><?php comments_number('0', '1', '%') ?></span>
                                            </div>
                                            <div class="likes">
                                                <img src="<?=get_template_directory_uri() . '/assets/images/heart.svg';?>"
                                                alt="icon: like" class="likes-icon">
                                                <span class="likes-counter"><?php comments_number('0', '1', '%') ?></span>
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
                            <img src="<?php the_post_thumbnail_url(); ?>" alt="<?=the_title()?>" class="article-grid-thumb" />
                            <a href="<?=get_permalink()?>" class="article-grid-permalink">
                                <h4 class="article-grid-title"><?=mb_strimwidth(get_the_title(), 0, 44, '...')?></h4>
                            </a>
                        </li>
                        <?php
                        break;
                    //Выводим остальные посты
                    default: ?>
                        <li class="article-grid-item article-grid-item-default">
                            <a href="<?=get_permalink()?>" class="article-grid-permalink">
                                <h4 class="article-grid-title"><?=mb_strimwidth(get_the_title(), 0, 23, '...')?></h4>
                                <p class="article-grid-excerpt"><?=mb_strimwidth(get_the_excerpt(), 0, 90, '...')?></p>
                                <span class="date"><?php the_time('j F') ?></span>
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
</div>
<!-- /.container -->
