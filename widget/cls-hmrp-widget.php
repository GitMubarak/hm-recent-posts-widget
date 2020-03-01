<?php
/**
* Adds HM Recent Posts widget in Widget area
*/
class Hmrpw_Widget extends WP_Widget {
	
	/**
	* Register widget with WordPress.
	*/
	function __construct() {
		parent::__construct(
			'hmrpw-widget', // Base ID
			__('HM Recent Posts', HMRPW_TXT_DOMAIN),
			array( 'description' => __( 'Display HM Recent Post', HMRPW_TXT_DOMAIN ), )
		);
	}
	
	/**
	* Front-end display of widget.
	*
	* @see WP_Widget::widget()
	*
	* @param array $args Widget arguments.
	* @param array $instance Saved values from database.
	*/
	public function widget( $args, $instance )
	{	
		echo $args['before_widget'];
		
		if ( !empty( $instance['title'] ) ){
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		$hmrpw_settings = stripslashes_deep(unserialize(get_option('hmrpw_settings')));
		$displayCategory = (isset($hmrpw_settings[ 'hmrpw_post_category' ])) ? $hmrpw_settings[ 'hmrpw_post_category' ] : 'Uncategorized';
		$noOfPosts = (isset($hmrpw_settings[ 'hmrpw_no_of_post' ])) ? $hmrpw_settings[ 'hmrpw_no_of_post' ] : 5;
		$theQuery = '';
		$queryArgs = array(	'cat' => $displayCategory, //category_name
							'showposts' => $noOfPosts, 
							'order' => 'DESC' );
		$theQuery = new WP_Query( $queryArgs );
		?>
		<div class="hmrpw-widget-view hmrpw-front-view" style="width:100%;">
			<ul>
				<?php while($theQuery->have_posts()) : $theQuery->the_post(); ?>
				<li>
					<div class="hmrpw-widget-thumbnail">
						<?php the_post_thumbnail( 'thumbnail' ); ?>
					</div>
					<div class="hmrpw-widget-content">
						<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="hmrpw-title"><?php the_title(); ?></a>
						<p class="hmrpw-time-category">
						<?php echo the_time('M d, Y'); ?> | <?php the_category(', ') ?>
						</p>
					</div>
				</li>
				<?php endwhile; ?>
			</ul>
		</div>
		<?php
		echo $args['after_widget'];
	}
	
	/**
	* Back-end widget form.
	*
	* @see WP_Widget::form()
	*
	* @param array $instance Previously saved values from database.
	*/
	public function form( $instance ) 
	{
		$instance = wp_parse_args( (array) $instance, array( 'title' => 'Recent Posts' ) );
		$title = $instance['title'];
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}
	
	/*
	* Sanitize widget form values as they are saved.
	*
	* @see WP_Widget::update()
	*
	* @param array $new_instance Values just sent to be saved.
	* @param array $old_instance Previously saved values from database.
	*
	* @return array Updated safe values to be saved.
	*/
	public function update( $new_instance, $old_instance ) 
	{
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		return $instance;
	}
}
?>