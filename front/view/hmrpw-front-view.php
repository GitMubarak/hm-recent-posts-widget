<?php
$hmrpw_settings = stripslashes_deep(unserialize(get_option('hmrpw_settings')));
$displayCategory = (isset($hmrpw_settings[ 'hmrpw_post_category' ])) ? $hmrpw_settings[ 'hmrpw_post_category' ] : 'Uncategorized';
$noOfPosts = (isset($hmrpw_settings[ 'hmrpw_no_of_post' ])) ? $hmrpw_settings[ 'hmrpw_no_of_post' ] : 5;
$hmrpwQueryArgsFront = array(	'cat' => $displayCategory,
                                'showposts' => $noOfPosts, 
                                'order' => 'DESC' );
$hmrpwQueryFront = new WP_Query( $hmrpwQueryArgsFront );
?>
<div class="hmrpw-shortcode-view hmrpw-front-view">
    <ul>
        <?php while($hmrpwQueryFront->have_posts()) : $hmrpwQueryFront->the_post(); ?>
        <li>
            <div class="hmrpw-shortcode-thumbnail">
                <?php the_post_thumbnail( 'thumbnail' ); ?>
            </div>
            <div class="hmrpw-shortcode-content">
                <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="hmrpw-title"><?php the_title(); ?></a>
                <p class="hmrpw-content">
                    <?php echo wp_trim_words(get_the_content(), 55); ?>
                </p>
                <p class="hmrpw-time-category">
                    <?php echo the_time('M d, Y'); ?> | <?php the_category(', ') ?>
                </p>
            </div>
        </li>
        <?php endwhile; ?>
    </ul>
</div>