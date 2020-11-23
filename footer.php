    <footer class="footer">
      <div class="container">
        <div class="footer-form-wrapper">
          <h3 class="footer-form-title">Подпишитесь на нашу рассылку</h3>
          <form action="https://app.getresponse.com/add_subscriber.html" accept-charset="utf-8" method="post" class="footer-form">
            <!-- Поле Email (обязательно) -->
            <input required type="text" name="email" placeholder="Введите email" class="input footer-form-input" />
            <!-- Токен списка -->
            <!-- Получить API ID на: https://app.getresponse.com/campaign_list.html -->
            <input type="hidden" name="campaign_token" value="BJdpl" />
            <!-- Страница благодарности (по желанию) -->
	          <input type="hidden" name="thankyou_url" value="<?=home_url('thankyou')?>" />
            <!-- Добавить подписчика в цикл на определенный день (по желанию) -->
            <input type="hidden" name="start_day" value="0" />
            <!-- Кнопка подписаться -->
            <button type="submit">Подписаться</button>
          </form>
        </div>
        <!-- /.footer-form -->
        <div class="footer-menu-bar">
          <?php dynamic_sidebar( 'sidebar-footer' ); ?>
        </div>
        <!-- /.footer-menu-bar -->
        <div class="footer-info">
          <?php if(has_custom_logo()){
            echo '<div class="logo">'. get_custom_logo( ).'</div>';
          }else{
            echo '<span class="logo-name">'. get_bloginfo('name') .'</span>';
          }
          
          wp_nav_menu( [
            'theme_location'  => 'footer_menu',
            'container'       => 'nav',
            'container_class' => 'footer-nav-wrapper',
            'menu_class'      => 'footer-nav', 
            'echo'            => true,
          ] );

          $instance = array(
            'title' => '',
            'facebook' => 'https://facebook.com',
            'instagram' => 'https://www.instagram.com',
            'vkontakte' => '',
            'twitter' => 'https://twitter.com',
            'youtube' => 'https://www.youtube.com',
          );
          $args = array(
            'before_widget' => '<div class="footer-social">',
            'after_widget' => '</div>',
          );
          the_widget( 'Social_Widget', $instance, $args ); ?>
        </div>
        <!-- /.footer-info -->
        <?php if ( ! is_active_sidebar( 'sidebar-footer' ) ) return; ?>
        <div class="footer-text-wrapper">
          <?php dynamic_sidebar( 'sidebar-footer-text' ); ?>
          <?php 
            $phone = get_field('phone', 108);
            if($phone) echo '<a href="tel:'.$phone.'">'.$phone.'</a>';
          ?>
          <span class="footer-copyright"><?php echo date('Y') . ' &copy; ' . get_bloginfo('name');?></php></span>
        </div>
        <!-- /.footer-text-wrapper -->
      </div>
      <!-- /.container -->
    </footer>
    <?php wp_footer(); ?>
  </body>
</html>
