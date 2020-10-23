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
                <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title()?>" class="post-thumb" />
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
                        foreach(get_the_category() as $category){
                            printf(
                                '<a href="%s" class="category-link">%s</a>',
                                esc_url( get_category_link($category)),
                                esc_html( $category -> name ),
                            );
                        }
                    ?>
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
                        <?php
                            foreach(get_the_category() as $category){
                                printf(
                                    '<a href="%s" class="category-link %s">%s</a>',
                                    esc_url( get_category_link($category)),
                                    esc_html( $category -> slug ),
                                    esc_html( $category -> name ),
                                );
                            }
                        ?>
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
    <div class="main-grid">
        <ul class="article-grid">
        <?php		
        global $post;
        //Формируем запрос в БД
        $query = new WP_Query( [
            //Получаем 7 постов
            'posts_per_page' => 7,
            'category__not_in' => 30,
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
                                <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title()?>" class="article-grid-thumb" />
                                <span class="category-name"><?php $category = get_the_category();
                                echo $category[0]->name; ?></span>
                                <h4 class="article-grid-title"><?=mb_strimwidth(get_the_title(), 0, 50, '...')?></h4>
                                <p class="article-grid-excerpt"><?=mb_strimwidth(get_the_excerpt(), 0, 100, '...')?></p>
                                <div class="article-grid-info">
                                    <div class="author">
                                        <?php $author_id = get_the_author_meta('ID'); ?>
                                        <img src="<?=get_avatar_url($author_id)?>" alt="<?php the_author()?>" class="author-avatar" />
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
                            <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title()?>" class="article-grid-thumb" />
                            <a href="<?=get_permalink()?>" class="article-grid-permalink">
                                <span class="tag"><?php $posttags = get_the_tags();
                                if($posttags) echo $posttags[0]->name . ' '; ?></span>
                                <span class="category-name"><?php $category = get_the_category();
                                echo $category[0]->name; ?></span>
                                <h4 class="article-grid-title"><?=mb_strimwidth(get_the_title(), 0, 50, '...')?></h4>
                                <div class="article-grid-info">
                                    <div class="author">
                                        <?php $author_id = get_the_author_meta('ID'); ?>
                                        <img src="<?=get_avatar_url($author_id)?>" alt="<?php the_author()?>" class="author-avatar" />
                                        <div class="author-info">
                                            <span class="author-name"><?=get_the_author()?></span>
                                            <span class="date"><?php the_time('j F') ?></span>
                                            <div class="comments">
                                                <img src="<?=get_template_directory_uri() . '/assets/images/comment-white.svg';?>"
                                                alt="icon: comment" class="comments-icon">
                                                <span class="comments-counter"><?php comments_number('0', '1', '%') ?></span>
                                            </div>
                                            <div class="likes">
                                                <img src="<?=get_template_directory_uri() . '/assets/images/heart-white.svg';?>"
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
                            <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title()?>" class="article-grid-thumb" />
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
    <!-- /.article-grid -->
    <!-- Подключаем верхний сайдбар -->
    <?php get_sidebar('home-top') ?>
    </div>
</div>
<!-- /.container -->
<?php		
global $post;
//Пост с большим фоном
$query = new WP_Query( [
	'posts_per_page' => 1,
	'category_name' => 'investigation',
] );

if ( $query->have_posts() ) {
	while ( $query->have_posts() ) {
		$query->the_post();
		?>
		<section class="investigation"
         style="background: linear-gradient(0deg, rgba(64, 48, 61, 0.35), rgba(64, 48, 61, 0.35)),url('<?=get_the_post_thumbnail_url()?>') no-repeat center center">
            <div class="container">
                <h2 class="investigation-title"><?php the_title() ?></h2>
                <a href="<?= get_the_permalink() ?>" class="more">Читать статью</a>
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
        <ul class="article-post">
        <?php		
        global $post;
        //Формируем запрос в БД
        $query = new WP_Query( [
            //Получаем 6 постов
            'posts_per_page' => 6,
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
                ?>
                <li class="article-post-item">
                    <a href="<?=get_permalink()?>" class="article-post-permalink">
                        <div class="article-post-half">
                            <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title()?>" class="article-post-thumb" />
                        </div>
                        <div class="article-post-half article-post-info">
                            <?php foreach(get_the_category() as $category){
                                printf(
                                    '<span class="category-name %s">%s</span>',
                                    esc_html( $category -> slug ),
                                    esc_html( $category -> name ),
                                );
                            }?>
                            <h4 class="article-post-title"><?=mb_strimwidth(get_the_title(), 0, 50, '...')?></h4>
                            <p class="article-post-excerpt"><?=mb_strimwidth(get_the_excerpt(), 0, 150, '...')?></p>
                            <div class="article-info">
                                <span class="date"><?php the_time('j F') ?></span>
                                <div class="comments">
                                    <img src="<?=get_template_directory_uri() . '/assets/images/comment.svg';?>"
                                        alt="icon: comment" class="comments-icon">
                                    <span class="comments-counter"><?php comments_number('0', '1', '%') ?></span>
                                </div>
                                <div class="likes">
                                    <img src="<?=get_template_directory_uri() . '/assets/images/heart.svg';?>"
                                        alt="icon: like" class="likes-icon">
                                    <span class="likes-counter"><?php comments_number('0', '1', '%') ?></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
                <?php
            }
        } else {
            ?> <p>Постов нет</p> <?php
        }
        wp_reset_postdata(); // Сбрасываем $post
        ?>
    </ul>
    <!-- /.article-post -->
    <!-- Подключаем верхний сайдбар -->
    <?php get_sidebar('home-bottom') ?>
</div>
<!-- /.container -->
