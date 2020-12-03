<form class="search-form" role="search" id="searchform" action="<?php echo home_url( '/' ) ?>">
  <input class="search-input" type="text" placeholder="<?php _e('Search', 'universal') ?>" value="<?php echo get_search_query() ?>" name="s" id="s" />
  <button class="search-button" type="submit" id="searchsubmit">
    <svg width="18" height="18" class="search-icon">
      <use xlink:href="<?=get_template_directory_uri()?>/assets/images/sprite.svg#search"></use>
    </svg>
  </button>
</form>
