<?php

if (! function_exists ( 'woteu_press_shortcode' )) {

	function woteu_press_shortcode($atts) {
            
               $a = shortcode_atts( array(
                    'nickname' => esc_attr( get_option( 'woteu-press-nickname' ) ),
                    'debug' => FALSE,
                ), $atts );
                     
            $nickname = $a['nickname'];
            $acc_id = wot_api($a['nickname'],'get_acc_id');
            $title = "Some Title";
            
            //Get the data
            $data = wot_api($acc_id, 'basic');
            $data_tanks = wot_api($acc_id, 'tanks');

            echo '<h4>'._e('Player Name', text_domain_parse()).'<a title="'.$title.'" target="_blank" href="http://worldoftanks.eu/community/accounts/'.$acc_id.'-'.$nickname.'/">'.$nickname.'</a></h4>';
            
            if ($a['debug']) {
                echo 'Debug info <br/>';
                echo 'Nickname: ' .$nickname. '<br/>';
                echo 'acc_id: ' .$acc_id.'<br/>';
            }
            if ($a['debug']) {
                echo 'Debug data <br/>';
                foreach ($data['data'][$acc_id] as $key => $value) {
                    echo str_replace('_',' ', $key).': '.$value.'<br>';
                 }
                 echo '<br/>';
            }
            if ($a['debug']) {
                echo 'Debug data:statistics <br/>';
                foreach ($data['data'][$acc_id]['statistics'] as $key => $value) {
                    echo str_replace('_',' ', $key).': '.$value.'<br>';
                 }
                 echo '<br/>';
            }
            if ($a['debug']) {
                echo 'Debug data:statistics:all <br/>';
                foreach ($data['data'][$acc_id]['statistics']['all'] as $key => $value) {
                    echo str_replace('_',' ', $key).': '.$value.'<br>';
                 }
                 echo '<br/>';
            }
            if ($a['debug']) {
                echo 'Debug data:statistics:clan <br/>';
                foreach ($data['data'][$acc_id]['statistics']['clan'] as $key => $value) {
                    echo str_replace('_',' ', $key).': '.$value.'<br>';
                 }
                 echo '<br/>';
            }
            
            if ($a['debug']) {
                echo 'Debug data_tanks:statistics <br/>';
                foreach ($data_tanks['data'][$acc_id] as $key => $value) {
                    echo str_replace('_',' ', $key).': '.$value.'<br>';
                 }
                 echo '<br/>';
            }
            
            echo 'count: '.sizeof($data_tanks['data'][$acc_id]).'<br/>';
            
            $max = sizeof($data_tanks['data'][$acc_id]);
            $count=0;
            $index=0;
            for($i = 0; $i < $max;$i++)
            {
                $tank_id[$index] .= $data_tanks['data'][$acc_id][$i]['tank_id'].',';
                $count++;
                if ($count == 100) {
                    $count = 0;
                    $index++;
                }
            }
            
            $max = sizeof($tank_id);
            for($i = 0; $i < $max;$i++) {
                $data_vehicles = wot_api($tank_id[$i],'vehicles');
            
                foreach (str_getcsv($tank_id[$i]) as $key => $value) {
                    echo $data_vehicles['data'][$value]['tag'];
                    echo '<img src="'.$data_vehicles['data'][$value]['images']['big_icon'].'" alt="'.$data_vehicles['data'][$value]['tag'].'"/><br/>';             
                    echo $data_vehicles['data'][$value]['description'].'<br/>';
                }
            }
                
            
            echo '<div>';
            //'<span>'._e('Battles fought', text_domain_parse()).':</span> '.$data['data'][$acc_id]['statistics']['all']['battles'].'<br/>';
            echo '<span>'._e('Client Language', text_domain_parse()).'</span>: '.$data['data'][$acc_id]['client_language'].'<br/>';
            echo '<span>'._e('Last Battle Time', text_domain_parse()) .'</span>: '. date('r', $data['data'][$acc_id]['last_battle_time']).'<br/>';
            echo '<span>'._e('Account Id', text_domain_parse()).'</span>: ' .$data['data'][$acc_id]['account_id'].'<br/>';
            echo '<span>'._e('Created At', text_domain_parse()).'</span>: ' .date('r', $data['data'][$acc_id]['created_at']).'<br/>';
            echo '<span>'._e('Updataed At', text_domain_parse()).'</span>: ' .date('r', $data['data'][$acc_id]['updated_at']).'<br/>';

            //"private":null,
            //"ban_time":null,
            //"global_rating":1846,
            //"clan_id":500012501,
            
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
            echo '<span>'._e('Maximum destroyed in battle', text_domain_parse()).':</span> '.$data['data'][$acc_id]['statistics']['all']['max_frags'].'<br/>';
            echo '<span>'._e('Maximum damage caused per battle', text_domain_parse()).':</span> '.$data['data'][$acc_id]['statistics']['all']['max_damage'].'<br/>';
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
                    
            echo '</div>';
	}

	add_shortcode ( 'woteu-press_shortcode', 'woteu_press_shortcode' );
}

?>