<?php

class Phoeniixx_pincode_check_Widget extends WP_Widget {
 
    public function __construct() {
     
        parent::__construct(
            'Phoeniixx_pincode_check_Widget',
            __( 'Phoeniixx Pincode Check Widget' ),
            array(
                'classname'   => 'Phoeniixx_pincode_check_Widget',
                'description' => __( 'Phoeniixx pinocode check widget.' )
                )
        );
       
        //load_plugin_textdomain( 'tutsplustextdomain', false, basename( dirname( __FILE__ ) ) . '/languages' );
       
    }
 
    /**  
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {    
         
        extract( $args );
         
        $title      = apply_filters( 'widget_title', $instance['title'] );
        //$message    = $instance['message'];
         
		//print_r($args);
		
        echo $before_widget;
         
        if ( $title ) {
            echo $before_title . $title . $after_title;
        }
                             
        //echo $message;
		
		phoe_pincode_check();
	
        echo $after_widget;
         
    }
 
  
    /**
      * Sanitize widget form values as they are saved.
      *
      * @see WP_Widget::update()
      *
      * @param array $new_instance Values just sent to be saved.
      * @param array $old_instance Previously saved values from database.
      *
      * @return array Updated safe values to be saved.
      */
    public function update( $new_instance, $old_instance ) {        
         
        $instance = $old_instance;
         
        $instance['title'] = strip_tags( $new_instance['title'] );
        //$instance['message'] = strip_tags( $new_instance['message'] );
         
        return $instance;
         
    }
  
    /**
      * Back-end widget form.
      *
      * @see WP_Widget::form()
      *
      * @param array $instance Previously saved values from database.
      */
    public function form( $instance ) {    
     
        $title      = esc_attr( $instance['title'] );
       // $message    = esc_attr( $instance['message'] );
        ?>
         
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <!--<p>
            <label for="<?php //echo $this->get_field_id('message'); ?>"><?php //_e('Simple Message'); ?></label> 
            <textarea class="widefat" rows="16" cols="20" id="<?php //echo $this->get_field_id('message'); ?>" name="<?php //echo $this->get_field_name('message'); ?>"><?php //echo $message; ?></textarea>
        </p>-->
     
    <?php 
    }
     
}
 
/* Register the widget */
add_action( 'widgets_init', function(){
     register_widget( 'Phoeniixx_pincode_check_Widget' );
});
?>