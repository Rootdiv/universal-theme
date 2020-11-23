<?php
/*
Template Name: Страница контактов
Template Post Type: page
*/

get_header();?>
<main>
  <section class="section-dark">
    <div class="container">
      <?php the_title('<h1 class="page-title">', '</h1>', true); ?>
      <div class="contacts-wrapper">
        <div class="left">
          <h2 class="contacts-title">Через форму обратной связи</h2>
          <!-- <form action="#" class="contacts-form" method="POST">
            <input name="contact_name" type="text" class="input contacts-input" placeholder="Ваше имя">
            <input name="contact_email" type="email" class="input contacts-input" placeholder="Ваш Email">
            <textarea name="contact_comment" id="" class="textarea contacts-textarea" placeholder="Ваш вопрос"></textarea>
            <button type="submit" class="button more">Отправить</button>
          </form> -->
          <div class="contacts-form">
            <?php //echo do_shortcode('[contact-form-7 id="204" title="Контактная форма"]') ?>
            <?php the_content() ?>
          </div>
        </div>
        <!-- /.left -->
        <div class="right">
          <h2 class="contacts-tile">Или по этим контактам</h2>
          <?php //Проверяем дополнительные поля
            $email = get_post_meta(get_the_ID(), 'email', true);
            if($email) echo '<a href="mailto:'.$email.'">'.$email.'</a>';
            $address = get_post_meta(get_the_ID(), 'address', true);
            if($address) echo '<address>'.$address.'</address>';
            $phone = get_field('phone');
            if($phone) echo '<a href="tel:'.$phone.'">'.$phone.'</a>';
          ?>
        </div>
        <!-- /.left -->
      </div>
      <!-- /.contacts-wrapper -->
    </div>
    <!-- /.container -->
  </section>
  <!-- /.section-dark -->
</main>
<?php get_footer();
