<?php get_header('post'); ?>
    <main id="primary" class="site-main">
      <?php
      //Запускаем цикл Wordpress и проверяем есть ли посты
      while ( have_posts() ) :
        //Если пост есть, выводим содержимое
        the_post();
        //Находим шаблон для вывода поста в папке template-parts
        get_template_part( 'template-parts/content', get_post_type() );
        //Если комментарии к записи открыты, выводим комментарии
        if ( comments_open() || get_comments_number() ) :
          //находим файл comments.php и выводим его
          comments_template();
        endif;
      endwhile; //Конец цикла Wordpress
      ?>
    </main>
<?php get_footer(); ?>
