<!--  searchform.php -->
<form role="search" method="get" id="searchform" class="form-search" action="<?php echo SITE_URL; ?>">
    <div class="input-block input-search">    
        <label class="visuallyhidden" for="s"><?php _e('Search'); ?></label>
        <input type="text" value="" name="s" id="s" class="search-query" placeholder="Search">
    </div>
    <input type="submit" id="searchsubmit" value="<?php _e('Search', 'roots'); ?>" class="btn">
</form>
<!-- // searchform.php -->