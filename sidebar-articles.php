<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package universal-theme
 */

if ( ! is_active_sidebar( 'sidebar-articles' ) ) {
 return;
}
?>

<aside class="sidebar-post-page">
  <?php dynamic_sidebar( 'sidebar-articles' ); ?>
</aside>
