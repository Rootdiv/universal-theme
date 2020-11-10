<?php
//Добавление расширенных возможностей
if ( ! function_exists( 'universal_theme_setup' ) ) :
  function universal_theme_setup() {
    //Добавление тега title
    add_theme_support( 'title-tag' );

    //Добавление миниатюр
    add_theme_support( 'post-thumbnails', array( 'post' ) );

    //Добавление пользовательского логотипа
    add_theme_support( 'custom-logo', [
      'width'       => 163,
      'flex-height' => true,
      'header-text' => 'Universal',
      'unlink-homepage-logo' => true, // WP 5.5
    ] );

    //Регистрация меню
    register_nav_menus( [
      'header_menu' => 'Menu in header',
      'footer_menu' => 'Menu in footer'
    ] );
  }
endif;
add_action( 'after_setup_theme', 'universal_theme_setup' );

/**
 * Подключение сайдбара.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function universal_theme_widgets_init() {
  register_sidebar(
    array(
      'name'          => esc_html__( 'Сайдбар на главной', 'universal-theme' ),
      'id'            => 'main-sidebar',
      'description'   => esc_html__( 'Добавьте виджеты сюда.', 'universal-theme' ),
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
    )
  );

  register_sidebar(
    array(
      'name'          => esc_html__( 'Последние статьи', 'universal-theme' ),
      'id'            => 'sidebar-recent-article',
      'description'   => esc_html__( 'Добавьте виджеты сюда.', 'universal-theme' ),
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
    )
  );

  register_sidebar(
    array(
      'name'          => esc_html__( 'Меню в подвале', 'universal-theme' ),
      'id'            => 'sidebar-footer',
      'description'   => esc_html__( 'Добавьте меню сюда.', 'universal-theme' ),
      'before_widget' => '<section id="%1$s" class="footer-menu %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h2 class="footer-menu-title">',
      'after_title'   => '</h2>',
    )
  );

  register_sidebar(
    array(
      'name'          => esc_html__( 'Текст в подвале', 'universal-theme' ),
      'id'            => 'sidebar-footer-text',
      'description'   => esc_html__( 'Добавьте текст сюда.', 'universal-theme' ),
      'before_widget' => '<section id="%1$s" class="footer-text %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '',
      'after_title'   => '',
    )
  );

    register_sidebar(
    array(
      'name'          => esc_html__( 'Статьи из категории', 'universal-theme' ),
      'id'            => 'sidebar-articles',
      'description'   => esc_html__( 'Добавьте виджеты сюда.', 'universal-theme' ),
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
    )
  );
}
add_action( 'widgets_init', 'universal_theme_widgets_init' );

/**
 * Добавление нового виджета Downloader_Widget.
 */
class Downloader_Widget extends WP_Widget {

 // Регистрация виджета используя основной класс
 function __construct() {
  // вызов конструктора выглядит так:
  // __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
  parent::__construct(
    'downloader_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: downloader_widget
    'Полезные файлы',
    array( 'description' => 'Файлы для скачивания.', 'classname' => 'widget-downloader', )
  );

  // скрипты/стили виджета, только если он активен
  if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
    //add_action('wp_enqueue_scripts', array( $this, 'add_downloader_widget_scripts' ));
    add_action('wp_head', array( $this, 'add_downloader_widget_style' ) );
  }
 }

 /**
  * Вывод виджета во Фронт-энде
  *
  * @param array $args     аргументы виджета.
  * @param array $instance сохраненные данные из настроек
  */
 function widget( $args, $instance ) {
    $title = $instance['title'];
    $description = $instance['description'];
    $link = $instance['link'];

    echo $args['before_widget'];?>
    <svg width="56" height="72" class="widget-downloader-icon">
      <use xlink:href="<?=get_template_directory_uri()?>/assets/images/sprite.svg#file"></use>
    </svg>
    <?php
    if ( ! empty( $title ) ) echo $args['before_title'] . $title . $args['after_title'];
    if ( ! empty( $description ) ) echo '<p class="description" >' . $description . '</p>';
    if ( ! empty( $link ) ) {
      echo '<a class="widget-link" href="' . $link . '" tagert="_blank">
      <svg width="17" height="17" fill="#ffffff" class="widget-link-icon">
        <use xlink:href="'.get_template_directory_uri().'/assets/images/sprite.svg#download"></use>
      </svg>
      Скачать</a>';
    }
    echo $args['after_widget'];
 }

 /**
  * Админ-часть виджета
  *
  * @param array $instance сохраненные данные из настроек
  */
  function form( $instance ) {
    $title = @ $instance['title'] ?: 'Полезные файлы';
    $description = @ $instance['description'] ?: 'Описание';
    $link = @ $instance['link'] ?: 'https://rootdiv.ru';

    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Заголовок:' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
    </p>
      <p>
      <label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e( 'Описание:' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" type="text" value="<?php echo esc_attr( $description ); ?>">
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Ссылка:' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>">
    </p>
    <?php 
  }

 /**
  * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
  *
  * @see WP_Widget::update()
  *
  * @param array $new_instance новые настройки
  * @param array $old_instance предыдущие настройки
  *
  * @return array данные которые будут сохранены
  */
  function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['description'] = ( ! empty( $new_instance['description'] ) ) ? strip_tags( $new_instance['description'] ) : '';
    $instance['link'] = ( ! empty( $new_instance['link'] ) ) ? strip_tags( $new_instance['link'] ) : '';

    return $instance;
  }

  // скрипт виджета
  function add_downloader_widget_scripts() {
  // фильтр чтобы можно было отключить скрипты
  if( ! apply_filters( 'show_downloader_widget_script', true, $this->id_base ) )
    return;

    $theme_url = get_stylesheet_directory_uri();

    wp_enqueue_script('downloader_widget_script', $theme_url .'/downloader_widget_script.js' );
  }

  // стили виджета
  function add_downloader_widget_style() {
    // фильтр чтобы можно было отключить стили
    if( ! apply_filters( 'show_downloader_widget_style', true, $this->id_base ) )
      return;
    ?>
    <style type="text/css">
      .downloader-widget a{ display:inline; }
    </style>
    <?php
  }
} 
// конец класса Downloader_Widget

// регистрация Downloader_Widget в WordPress
function register_downloader_widget() {
 register_widget( 'Downloader_Widget' );
}
add_action( 'widgets_init', 'register_downloader_widget' );

/**
 * Добавление нового виджета Social_Widget.
 */
class Social_Widget extends WP_Widget {

  // Регистрация виджета используя основной класс
  function __construct() {
    // вызов конструктора выглядит так:
    // __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
    parent::__construct(
      'social_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: foo_widget
      'Социальные сети',
      array( 'description' => 'Ссылки на социальные сети.', 'classname' => 'widget-social', )
    );

    // скрипты/стили виджета, только если он активен
    if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
      //add_action('wp_enqueue_scripts', array( $this, 'add_social_widget_scripts' ));
      add_action('wp_head', array( $this, 'add_social_widget_style' ) );
    }
  }

  /**
  * Вывод виджета во Фронт-энде
  *
  * @param array $args     аргументы виджета.
  * @param array $instance сохраненные данные из настроек
  */
  function widget( $args, $instance ) {
    $title = $instance['title'];
    $facebook = $instance['facebook'];
    $instagram = $instance['instagram'];
    $vkontakte = $instance['vkontakte'];
    $twitter = $instance['twitter'];
    $youtube = $instance['youtube'];

  echo $args['before_widget'];
  if ( ! empty( $title ) ) echo $args['before_title'] . $title . $args['after_title'];
    echo '<div class="widget-social-link">';
    if ( ! empty( $facebook ) ) {
      echo '<a class="widget-social-link-fb" href="' . $facebook . '" tagert="_blank">
        <svg width="20" height="20" fill="#ffffff" class="widget-link-icon">
          <use xlink:href="'.get_template_directory_uri().'/assets/images/sprite.svg#facebook"></use>
        </svg>
      </a>';
    }
    if ( ! empty( $instagram ) ) {
      echo '<a class="widget-social-link-inst" href="' . $instagram . '" tagert="_blank">
        <svg width="20" height="20" fill="#ffffff" class="widget-link-icon">
          <use xlink:href="'.get_template_directory_uri().'/assets/images/sprite.svg#instagram"></use>
        </svg>
      </a>';
    }
    if ( ! empty( $vkontakte ) ) {
      echo '<a class="widget-social-link-vk" href="' . $vkontakte . '" tagert="_blank">
        <svg width="20" height="20" fill="#ffffff" class="widget-link-icon">
          <use xlink:href="'.get_template_directory_uri().'/assets/images/sprite.svg#vk"></use>
        </svg>
      </a>';
    }
    if ( ! empty( $twitter ) ) {
      echo '<a class="widget-social-link-twit" href="' . $twitter . '" tagert="_blank">
        <svg width="20" height="20" fill="#ffffff" class="widget-link-icon">
          <use xlink:href="'.get_template_directory_uri().'/assets/images/sprite.svg#twitter"></use>
        </svg>
      </a>';
    }
    if ( ! empty( $youtube ) ) {
      echo '<a class="widget-social-link-yt" href="' . $youtube . '" tagert="_blank">
        <svg width="20" height="20" fill="#ffffff" class="widget-link-icon">
          <use xlink:href="'.get_template_directory_uri().'/assets/images/sprite.svg#youtube"></use>
        </svg>
      </a>';
    }
    echo '</div>';
    echo $args['after_widget'];
  }

 /**
  * Админ-часть виджета
  *
  * @param array $instance сохраненные данные из настроек
  */
 function form( $instance ) {
    $title = @ $instance['title'] ?: 'Наши соцсети';
    $facebook = @ $instance['facebook'] ?: '';
    $instagram = @ $instance['instagram'] ?: '';
    $vkontakte = @ $instance['vkontakte'] ?: '';
    $twitter = @ $instance['twitter'] ?: '';
    $youtube = @ $instance['youtube'] ?: '';

  ?>
  <p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Заголовок:' ); ?></label> 
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
  </p>
  <p>
    <label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e( 'Facebook:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" type="text" value="<?php echo esc_attr( $facebook ); ?>">
  </p>
  <p>
    <label for="<?php echo $this->get_field_id( 'instagram' ); ?>"><?php _e( 'Instagram:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'instagram' ); ?>" name="<?php echo $this->get_field_name( 'instagram' ); ?>" type="text" value="<?php echo esc_attr( $instagram ); ?>">
  </p>
  <p>
    <label for="<?php echo $this->get_field_id( 'vkontakte' ); ?>"><?php _e( 'ВКонтакте:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'vkontakte' ); ?>" name="<?php echo $this->get_field_name( 'vkontakte' ); ?>" type="text" value="<?php echo esc_attr( $vkontakte ); ?>">
  </p>
  <p>
    <label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e( 'Twitter:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" type="text" value="<?php echo esc_attr( $twitter ); ?>">
  </p>
  <p>
    <label for="<?php echo $this->get_field_id( 'youtube' ); ?>"><?php _e( 'Youtube:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'youtube' ); ?>" name="<?php echo $this->get_field_name( 'youtube' ); ?>" type="text" value="<?php echo esc_attr( $youtube ); ?>">
  </p>
  <?php
 }

  /**
  * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
  *
  * @see WP_Widget::update()
  *
  * @param array $new_instance новые настройки
  * @param array $old_instance предыдущие настройки
  *
  * @return array данные которые будут сохранены
  */
  function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['facebook'] = ( ! empty( $new_instance['facebook'] ) ) ? strip_tags( $new_instance['facebook'] ) : '';
    $instance['instagram'] = ( ! empty( $new_instance['instagram'] ) ) ? strip_tags( $new_instance['instagram'] ) : '';
    $instance['vkontakte'] = ( ! empty( $new_instance['vkontakte'] ) ) ? strip_tags( $new_instance['vkontakte'] ) : '';
    $instance['twitter'] = ( ! empty( $new_instance['twitter'] ) ) ? strip_tags( $new_instance['twitter'] ) : '';
    $instance['youtube'] = ( ! empty( $new_instance['youtube'] ) ) ? strip_tags( $new_instance['youtube'] ) : '';

    return $instance;
  }

  // скрипт виджета
  function add_social_widget_scripts() {
  // фильтр чтобы можно было отключить скрипты
  if( ! apply_filters( 'show_social_widget_script', true, $this->id_base ) )
    return;

    $theme_url = get_stylesheet_directory_uri();

    wp_enqueue_script('social_widget_script', $theme_url .'/social_widget_script.js' );
  }

  // стили виджета
  function add_social_widget_style() {
    // фильтр чтобы можно было отключить стили
    if( ! apply_filters( 'show_social_widget_style', true, $this->id_base ) )
    return;
    ?>
    <style type="text/css">
      .social_widget a{ display:inline; }
    </style>
    <?php
  }
} 
// конец класса Social_Widget

// регистрация Social_Widget в WordPress
function register_social_widget() {
  register_widget( 'Social_Widget' );
}
add_action( 'widgets_init', 'register_social_widget' );

/**
 * Добавление нового виджета Recent_Post_Widget.
 */
class Recent_Post_Widget extends WP_Widget {

  // Регистрация виджета используя основной класс
  function __construct() {
  // вызов конструктора выглядит так:
  // __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
  parent::__construct(
    'recent_post_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: foo_widget
    'Недавно опубликовано',
    array( 'description' => 'Последние посты.', 'classname' => 'widget-recent-posts', )
  );

  // скрипты/стили виджета, только если он активен
  if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
    //add_action('wp_enqueue_scripts', array( $this, 'add_recent_post_widget_scripts' ));
    add_action('wp_head', array( $this, 'add_recent_post_widget_style' ) );
    }
  }

  /**
  * Вывод виджета во Фронт-энде
  *
  * @param array $args     аргументы виджета.
  * @param array $instance сохраненные данные из настроек
  */
  function widget( $args, $instance ) {
    $title = $instance['title'];
    $count = $instance['count'];
    
    echo $args['before_widget'];
      if ( ! empty( $count ) ) {
        if ( ! empty( $title ) ) {
          echo $args['before_title'] . $title . $args['after_title'];
        }
        echo '<div class="widget-recent-posts-wrapper">';
          global $post;
          $postslist = get_posts( array( 'posts_per_page' => $count, 'order'=> 'ASC', 'orderby' => 'title' ) );
          foreach ( $postslist as $post ){
            setup_postdata($post);?>
          <a href="<?php the_permalink() ?>" class="recent-post-link">
          <img class="recent-post-thumb" src="<?php
            if( has_post_thumbnail() ) echo get_the_post_thumbnail_url(null, 'thumbnail');
            else echo get_template_directory_uri().'/assets/images/img-default.png';
          ?>" alt="<?php the_title(); ?>">
            <div class="recent-post-info">
              <h4 class="recent-post-title"><?=mb_strimwidth(get_the_title(), 0, 35, '...')?></h4>
              <span class="recent-post-time">
                <?php $time_diff = human_time_diff( get_post_time('U'), current_time('timestamp') );
                echo "$time_diff назад";?>
              </span>
            </div>
          </a>
          <?php
          }
          wp_reset_postdata();
        echo '</div>';
      }
    echo $args['after_widget'];
  }

  /**
  * Админ-часть виджета
  *
  * @param array $instance сохраненные данные из настроек
  */
    function form( $instance ) {
      $title = @ $instance['title'] ?: 'Недавно опубликовано';
      $count = @ $instance['count'] ?: '7';

    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Заголовок:' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Количество постов:' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>">
    </p>
    <?php 
  }

  /**
  * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
  *
  * @see WP_Widget::update()
  *
  * @param array $new_instance новые настройки
  * @param array $old_instance предыдущие настройки
  *
  * @return array данные которые будут сохранены
  */
  function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['count'] = ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';

    return $instance;
  }

  // скрипт виджета
  function add_recent_post_widget_scripts() {
  // фильтр чтобы можно было отключить скрипты
  if( ! apply_filters( 'show_recent_post_widget_script', true, $this->id_base ) )
   return;

  $theme_url = get_stylesheet_directory_uri();

  wp_enqueue_script('recent_post_widget_script', $theme_url .'/recent_post_widget_script.js' );
 }

  // стили виджета
  function add_recent_post_widget_style() {
    // фильтр чтобы можно было отключить стили
    if( ! apply_filters( 'show_recent_post_widget_style', true, $this->id_base ) )
    return;
    ?>
    <style type="text/css">
      .recent-post-widget a{ display:inline; }
    </style>
    <?php
  }
}
// конец класса Recent_Post_Widget

// регистрация Recent_Post_Widget в WordPress
function register_recent_post_widget() {
  register_widget( 'Recent_Post_Widget' );
}
add_action( 'widgets_init', 'register_recent_post_widget' );

/**
 * Добавление нового виджета Posts_Widget.
 */
class Posts_Widget extends WP_Widget {

  // Регистрация виджета используя основной класс
  function __construct() {
  // вызов конструктора выглядит так:
  // __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
  parent::__construct(
    'posts_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: foo_widget
    'Статьи из категории',
    array( 'description' => 'Статьи из определённой категории.', 'classname' => 'widget-posts', )
  );

  // скрипты/стили виджета, только если он активен
  if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
    //add_action('wp_enqueue_scripts', array( $this, 'add_posts_widget_scripts' ));
    add_action('wp_head', array( $this, 'add_posts_widget_style' ) );
    }
  }

  /**
  * Вывод виджета во Фронт-энде
  *
  * @param array $args     аргументы виджета.
  * @param array $instance сохраненные данные из настроек
  */
  function widget( $args, $instance ) {
    $title = $instance['title'];
    $count = $instance['count'];
    
    echo $args['before_widget'];
      if ( ! empty( $count ) ) {
        if ( ! empty( $title ) ) {
          echo $args['before_title'] . $title . $args['after_title'];
        }
        echo '<div class="widget-posts-wrapper">';
          global $post;
          $category = get_the_category();
          rsort( $category );
          $category_slug = $category[0]->slug;

          $posts = get_posts( array(
            'category_name'    => $category_slug,
            'posts_per_page' => $count,
            'exclude' => $GLOBALS['post']->ID,
          ) );

          foreach( $posts as $post ){
            setup_postdata($post);?>
          <a href="<?php the_permalink() ?>" class="posts-link">
          <img class="posts-thumb" src="<?php
            if( has_post_thumbnail() ) echo get_the_post_thumbnail_url();
            else echo get_template_directory_uri().'/assets/images/img-default.png';
          ?>" alt="<?php the_title(); ?>">
            <h4 class="posts-title"><?=mb_strimwidth(get_the_title(), 0, 60, '...')?></h4>
            <div class="posts-info">
              <div class="views">
                <svg width="15" height="10" class="views-icon">
                  <use xlink:href="<?=get_template_directory_uri()?>/assets/images/sprite.svg#eye"></use>
                </svg>
                <span class="likes-counter"><?php comments_number('0', '1', '%')?></span>
              </div>
              <div class="comments">
                <svg width="14" height="14" class="comments-icon">
                  <use xlink:href="<?=get_template_directory_uri()?>/assets/images/sprite.svg#comment"></use>
                </svg>
                <span class="comments-counter"><?php comments_number('0', '1', '%')?></span>
              </div>
            </div>
          </a>
          <?php
          }
          wp_reset_postdata();
        echo '</div>';
      }
    echo $args['after_widget'];
  }

  /**
  * Админ-часть виджета
  *
  * @param array $instance сохраненные данные из настроек
  */
    function form( $instance ) {
      $title = @ $instance['title'] ?: 'Рекомендуемое';
      $count = @ $instance['count'] ?: '4';

    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Заголовок:' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Количество постов:' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>">
    </p>
    <?php 
  }

  /**
  * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
  *
  * @see WP_Widget::update()
  *
  * @param array $new_instance новые настройки
  * @param array $old_instance предыдущие настройки
  *
  * @return array данные которые будут сохранены
  */
  function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['count'] = ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';

    return $instance;
  }

  // скрипт виджета
  function add_posts_widget_scripts() {
  // фильтр чтобы можно было отключить скрипты
  if( ! apply_filters( 'show_posts_widget_script', true, $this->id_base ) )
   return;

  $theme_url = get_stylesheet_directory_uri();

  wp_enqueue_script('posts_widget_script', $theme_url .'/posts_widget_script.js' );
 }

  // стили виджета
  function add_posts_widget_style() {
    // фильтр чтобы можно было отключить стили
    if( ! apply_filters( 'show_posts_widget_style', true, $this->id_base ) )
    return;
    ?>
    <style type="text/css">
      .posts-widget a{ display:inline; }
    </style>
    <?php
  }
}
// конец класса Posts_Widget

// регистрация Posts_Widget в WordPress
function register_posts_widget() {
  register_widget( 'Posts_Widget' );
}
add_action( 'widgets_init', 'register_posts_widget' );

//Подключение стилей и скриптов
function enqueue_universal_style() {
  wp_enqueue_style( 'style', get_stylesheet_uri() );
  wp_enqueue_style( 'swipe-slider', get_template_directory_uri().'/assets/css/swiper-bundle.min.css', 'universal-theme', time() );
  wp_enqueue_style( 'universal-theme', get_template_directory_uri().'/assets/css/universal-theme.css', 'style', time() );
  wp_enqueue_style( 'Roboto-Slab', 'https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@700&display=swap');
  wp_deregister_script( 'jquery-core' );
	wp_register_script( 'jquery-core', '//code.jquery.com/jquery-3.5.1.min.js');
	wp_enqueue_script( 'jquery' );
  wp_enqueue_script( 'swiper', get_template_directory_uri().'/assets/js/swiper-bundle.min.js', null, time(), true);
  wp_enqueue_script( 'scripts', get_template_directory_uri().'/assets/js/scripts.js', 'swiper', time(), true);
}
add_action( 'wp_enqueue_scripts', 'enqueue_universal_style' );

#Изменяем настройки облака тегов
add_action( 'widget_tag_cloud_args', 'edit_widget_tag_cloud_args' );
function edit_widget_tag_cloud_args($args){
  $args['unit'] = 'px';
  $args['smallest'] = 14;
  $args['largest'] = 14;
  $args['number'] = 12;
  $args['orderby'] = 'count';
  return $args;
}

#Отключаем создание миниатюр файлов для указанных размеров
add_filter( 'intermediate_image_sizes', 'delete_intermediate_image_sizes' );
function delete_intermediate_image_sizes( $sizes ){
  //размеры которые нужно удалить
  return array_diff( $sizes, [
    'medium',
    'medium_large',
    'large',
    '1536x1536',
    '2048x2048',
  ] );
}

#Отмена `-scaled` размера - ограничение максимального размера картинки 
add_filter( 'big_image_size_threshold', '__return_zero' );

#Меняем стиль многоточия в отрывках
add_filter('excerpt_more', function($more) {
	return '...';
});

//Склонение слов после числительных
function plural_form($number, $after) {
	$cases = array (2, 0, 1, 1, 1, 2);
	echo $number.' '.$after[ ($number%100>4 && $number%100<20)? 2: $cases[min($number%10, 5)] ];
}
