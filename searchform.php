<!--  searchform.php -->
<form action="<?php echo SITE_URL; ?>" id="searchform" method="get">
    <div class="input-block input-search">
        <label for="search">Search</label>
        <input type="text" name="s" value="" />
             <?php // generate list of searchable post categories
        wp_dropdown_categories( array(
                    'show_option_all' => 'All categories',
                    
                    'orderby' => 'name'
                    ) ); ?>
        <input type="submit" value="Search" id="searchsubmit" />
    </div>
</form>

<!-- // searchform.php -->