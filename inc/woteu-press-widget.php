<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if( !class_exists('WOT_Press') ){

class WOT_Press extends WP_Widget {
		
    private $defaults;
    private $text_domain;

    function __construct()	{
            $options = array(
        'description'   =>  'Displays account data from Wargaming.net. Now is statistic from your profile in World of Tanks game available.',
        'name'          =>  'WOT Press'
    );

            parent::__construct('wot_press', '', $options);

            $this->defaults =  array(
            'title'			=> 'My Profile in WOT',
            'nickname'                  => esc_attr( get_option( 'woteu-press-nickname' ) ),
            'profile_link'		=> 'on'
            );

            //$this->text_domain = 'woteu-press';
            //add_action('init', array(&$this,'text_domain_parse'));           
    }
	
    public function form($instance)	{

            $instance = wp_parse_args((array)$instance, $this->defaults);
            $title = ! empty($instance['title']) ? $instance['title'] : '';
            $nickname = ! empty($instance['nickname']) ? $instance['nickname'] : '';
            $profile_link = ! empty($instance['profile_link']) ? $instance['profile_link'] : '';
            ?>
            <p>
                <label for="<?=$this->get_field_id('title'); ?>"><?php _e('Title', text_domain_parse()); ?></label> 
                <input class="widefat" id="<?=$this->get_field_id('title'); ?>" name="<?=$this->get_field_name('title'); ?>" type="text" value="<?=esc_attr($title); ?>">
            </p>
            <p>
                <label for="<?=$this->get_field_id('nickname'); ?>"><?php _e('Nickname', text_domain_parse()); ?></label> 
                <input class="widefat" id="<?=$this->get_field_id('nickname'); ?>" name="<?=$this->get_field_name('nickname'); ?>" type="text" value="<?=esc_attr($nickname); ?>">
            </p>
            <p>
                <input class="checkbox" type="checkbox" <?php checked($profile_link, 'on'); ?> id="<?=$this->get_field_id('profile_link'); ?>" name="<?=$this->get_field_name('profile_link'); ?>" /> 
                <label for="<?=$this->get_field_id('profile_link'); ?>"> <?php _e('Profile Link', text_domain_parse()); ?></label>
            </p>
                    <?php 
    }

    public function widget($args, $instance)	{

            $title = $instance['title'];
            $nickname = $instance['nickname'];
            $profile_link = $instance['profile_link'];
            
            echo $args['before_widget'];
            if($title)	{
                    echo '<h3 class="woteu-press-widget-title">'.$title.'</h3>';
            }
            if(!$nickname)	{
                    echo _e('Nickname not specified', text_domain_parse()); return;
            }	else {
                    $acc_id = wot_api($nickname,'get_acc_id');
                    
                    if($profile_link)	{
                            echo '<h4><a title="'.$title.'" target="_blank" href="http://worldoftanks.eu/community/accounts/'.$acc_id.'-'.$nickname.'/">'.$nickname.'</a></h4>';
                    }	else {
                            echo '<h4>'.$nickname.'</h4>';
                    }

                    $data = wot_api($acc_id, 'basic');

                    echo '<span>'._e('Battles fought', text_domain_parse()).':</span> '.$data['data'][$acc_id]['statistics']['all']['battles'].'<br/>';
                    echo '<span>'._e('Personal rating', text_domain_parse()).':</span> '.$data['data'][$acc_id]['global_rating'].'<br/>';
                    echo '<span>'._e('Hits', text_domain_parse()).':</span> '.$data['data'][$acc_id]['statistics']['all']['hits'].'<br/>';
                    echo '<span>'._e('Victories', text_domain_parse()).':</span> '.$data['data'][$acc_id]['statistics']['all']['wins'].'<br/>';
                    echo '<span>'._e('Defeats', text_domain_parse()).':</span> '.$data['data'][$acc_id]['statistics']['all']['losses'].'<br/>';
                    echo '<span>'._e('Draws', text_domain_parse()).':</span> '.$data['data'][$acc_id]['statistics']['all']['draws'].'<br/>';
                    echo '<span>'._e('Total experience', text_domain_parse()).':</span> '.$data['data'][$acc_id]['statistics']['all']['xp'].'<br/>';
                    echo '<span>'._e('Average experience per battle', text_domain_parse()).':</span> '.$data['data'][$acc_id]['statistics']['all']['battle_avg_xp'].'<br/>';
                    echo '<span>'._e('Maximum experience per battle', text_domain_parse()).':</span> '.$data['data'][$acc_id]['statistics']['all']['max_xp'].'<br/>';
                    echo '<span>'._e('Vehicles destroyed', text_domain_parse()).':</span> '.$data['data'][$acc_id]['statistics']['all']['frags'].'<br/>';
                    echo '<span>'._e('Shots fired', text_domain_parse()).':</span> '.$data['data'][$acc_id]['statistics']['all']['shots'].'<br/>';
                    echo '<span>'._e('Maximum destroyed in battle', text_domain_parse()).':</span> '.$data['data'][$acc_id]['statistics']['max_frags'].'<br/>';
                    echo '<span>'._e('Maximum damage caused per battle', text_domain_parse()).':</span> '.$data['data'][$acc_id]['statistics']['max_damage'].'<br/>';
                    echo '<span>'._e('Hit ratio', text_domain_parse()).':</span> '.$data['data'][$acc_id]['statistics']['all']['hits_percents'].'<br/>';
                    echo '<span>'._e('Base capture points', text_domain_parse()).':</span> '.$data['data'][$acc_id]['statistics']['all']['capture_points'].'<br/>';
                    echo '<span>'._e('Base defense points', text_domain_parse()).':</span> '.$data['data'][$acc_id]['statistics']['all']['dropped_capture_points'].'<br/>';
                    echo '<span>'._e('Penetrations', text_domain_parse()).':</span> '.$data['data'][$acc_id]['statistics']['all']['piercings'].'<br/>';
                    echo '<span>'._e('Battles survived', text_domain_parse()).':</span> '.$data['data'][$acc_id]['statistics']['all']['survived_battles'].'<br/>';
                    $epoch = $data['data'][$acc_id]['logout_at'];
                    echo date('r', $epoch); // output as RFC 2822 date - returns local time
                    echo gmdate('r', $epoch); // returns GMT/UTC time
                   
                    if($profile_link)	{
                            echo '<br/><a title="'.$title.'" target="_blank" href="http://worldoftanks.eu/community/accounts/'.$acc_id.'-'.$nickname.'/"><img src="https://worldoftanks.ru/dcont/fb/signatures/wotsigna006.jpg" alt="'.$title.'"/></a>';
                    }
                    /* debug 
                    foreach ($data as $key => $value) {
                        echo 'key: '.$key.' value: '.$value.'<br>';
                    }
                    foreach ($data['data'][$acc_id]['statistics']['all'] as $key => $value) {
                        echo 'key: '.$key.' value: '.$value.'<br>';
                    }                     
                    */
                    echo $args['after_widget'];
            }
    }

    public function update($new_instance, $old_instance)	{
            $instance = array();
            $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
            $instance['nickname'] = (!empty($new_instance['nickname'])) ? strip_tags($new_instance['nickname']) : '';
            $instance['profile_link'] = (!empty($new_instance['profile_link'])) ? strip_tags($new_instance['profile_link']) : '';

            return $instance;
    }

}
    // register widget
   function register_wot_widget()	{
    register_widget('WOT_Press');
  }
  add_action('widgets_init', 'register_wot_widget');
}