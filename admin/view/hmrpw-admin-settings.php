<?php
$hmrpwShowMessage = false;

if(isset($_POST['updateSettings'])){
    $hmrpwSettingsInfo = array(
                                'hmrpw_no_of_post' => (!empty($_POST['hmrpw_no_of_post']) && (sanitize_text_field($_POST['hmrpw_no_of_post'])!='')) ? sanitize_text_field($_POST['hmrpw_no_of_post']) : 5,
                                'hmrpw_post_title_color' => (!empty($_POST['hmrpw_post_title_color'])) ? sanitize_text_field($_POST['hmrpw_post_title_color']) : '#FF9700',
                                'hmrpw_post_category' => sanitize_text_field($_POST['hmrpw_post_category']),
                                'hmrpw_ticker_direction' => sanitize_text_field($_POST['hmrpw_ticker_direction']),
                            );
     $hmrpwShowMessage = update_option('hmrpw_settings', serialize($hmrpwSettingsInfo));
}
$hmrpw_settings = stripslashes_deep(unserialize(get_option('hmrpw_settings')));
?>
<div id="wph-wrap-all" class="wrap">
    <div class="settings-banner">
        <h2><?php esc_html_e('HM Recent Posts', HMRPW_TXT_DOMAIN); ?></h2>
    </div>
    <?php if($hmrpwShowMessage): $this->hmrpw_display_notification('success', 'Your information updated successfully.'); endif; ?>

    <form name="wpre-table" role="form" class="form-horizontal" method="post" action="" id="hmrpw-settings-form">
        <table class="form-table">
        <tr class="hmrpw_post_title_color">
            <th scope="row">
                <label for="hmrpw_post_title_color"><?php esc_html_e('Post Title Color:', HMRPW_TXT_DOMAIN); ?></label>
            </th>
            <td>
                <input class="hmrpw-wp-color" type="text" name="hmrpw_post_title_color" id="hmrpw_post_title_color" value="<?php echo esc_attr($hmrpw_settings['hmrpw_post_title_color']); ?>">
                <div id="colorpicker"></div>
            </td>
        </tr>
        <tr class="hmrpw_no_of_post">
            <th scope="row">
                <label for="hmrpw_no_of_post"><?php esc_html_e('No of Post:', HMRPW_TXT_DOMAIN); ?></label>
            </th>
            <td>
                <input type="number" name="hmrpw_no_of_post" id="hmrpw_no_of_post" class="small-text" value="<?php echo esc_attr( $hmrpw_settings['hmrpw_no_of_post'] ); ?>" step="1" min="1" size="4">
            </td>
        </tr>
        <tr class="hmrpw_post_category">
            <th scope="row">
                <label for="hmrpw_post_category"><?php esc_html_e('Post Category:', HMRPW_TXT_DOMAIN); ?></label>
            </th>
            <td>
                <select class="medium-text" id="hmrpw_post_category" name="hmrpw_post_category">
                    <option value="">All Category</option>
                    <?php 
                    $hmrpw_args = array(  	'type'                     => 'post',
                                            'child_of'                 => 0,
                                            'parent'                   => '',
                                            'orderby'                  => 'name',
                                            'order'                    => 'ASC',
                                            'hide_empty'               => 1,
                                            'hierarchical'             => 1,
                                            'exclude'                  => '',
                                            'include'                  => '',
                                            'number'                   => '',
                                            'taxonomy'                 => 'category',
                                            'pad_counts'               => false 	
                                        ); 
                    $hmrpw_categories = get_categories( $hmrpw_args ); 
                    foreach( $hmrpw_categories as $cat ) :
                    ?>
                    <option <?php if( $cat->cat_ID == $hmrpw_settings['hmrpw_post_category'] ) echo 'selected'; ?> value="<?php echo esc_attr($cat->cat_ID); ?>"><?php echo esc_html($cat->name); ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr class="hmrpw_ticker_direction">
            <th scope="row">
                <label for="hmrpw_ticker_direction"><?php esc_html_e('Ticker Direction:', HMRPW_TXT_DOMAIN); ?></label>
            </th>
            <td>
                <input type="radio" name="hmrpw_ticker_direction" class="hmrpw_ticker_direction" value="up" <?php if($hmrpw_settings['hmrpw_ticker_direction'] == "up") { echo 'checked'; } ?>>
                <label for="hmrpw_ticker_direction_up"><span></span><?php esc_attr_e('Up', HMRPW_TXT_DOMAIN); ?></label>
                &nbsp;
                <input type="radio" name="hmrpw_ticker_direction" class="hmrpw_ticker_direction" value="down" <?php if($hmrpw_settings['hmrpw_ticker_direction'] == "down") { echo 'checked'; } ?>>
                <label for="hmrpw_ticker_direction_down"><span></span><?php esc_attr_e('Down', HMRPW_TXT_DOMAIN); ?></label>
            </td>
        </tr>
        <tr class="hmrpw_shortcode">
               <th scope="row">
                    <label for="hmrpw_shortcode"><?php esc_html_e('Shortcode: ', HMRPW_TXT_DOMAIN); ?></label>
               </th>
               <td>
                    <input type="text" name="hmrpw_shortcode" id="hmrpw_shortcode" class="regular-text" value="[hm_recent_posts]" readonly />
               </td>
          </tr>
        </table>
        <p class="submit"><button id="updateSettings" name="updateSettings" class="button button-primary"><?php esc_attr_e('Update Settings', HMRPW_TXT_DOMAIN); ?></button></p>
    </form>
</div>