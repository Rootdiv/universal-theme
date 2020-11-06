    <footer class="footer">
      <div class="container">
        <div class="footer-menu-bar">
          <?php dynamic_sidebar( 'sidebar-footer' ); ?>
        </div>
        <!-- /.footer-menu-bar -->
        <div class="footer-info">
          <?php if(has_custom_logo()){
            echo '<div class="logo">'. get_custom_logo( ).'</div>';
          }else{
            echo '<div class="logo"><span>'. get_bloginfo('name') .'</span></div>';
          } ?>
        <?php
          wp_nav_menu( [
            'theme_location'  => 'footer_menu',
            'container'       => 'nav', 
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
          <span class="footer-copyright"><?php echo date('Y') . ' &copy; ' . get_bloginfo('name');?></php></span>
        </div>
        <!-- /.footer-text-wrapper -->
      </div>
      <!-- /.container -->
    </footer>
    <?php wp_footer(); ?>
  </body>
</html>
