<?php
/* Handle the meta box saving */
global $post, $wpdb;
?>
<style>
    input[type=text],textarea{
        width:100%
    }
</style>
<table class="form-table">
    <thead></thead>
    <tfoot></tfoot>
    <tbody>
        
        <tr>
            <th><?php esc_html_e("Nickname", ZTEC_TEXT_DOMAIN);?></th>
            <td>
                <?php $nickname = get_post_meta($post->ID, '_ztec_team_nickname', true); ?>
                <input type="text" name="nickname" autocomplete="off" value="<?php esc_attr_e($nickname); ?>" required />
            </td>
        </tr>

        <tr>
            <th><?php esc_html_e("History", ZTEC_TEXT_DOMAIN);?></th>
            <td>
                <?php $history = get_post_meta($post->ID, '_ztec_team_history', true); ?>
                <textarea id="history" name="history" rows="4" cols="50"><?php esc_attr_e($history); ?></textarea>
            </td>
        </tr>
        <tr>
            <th><?php esc_html_e("Add Players", ZTEC_TEXT_DOMAIN);?></th>
            <td>
                <?php $getplayer_data = get_post_meta($post->ID, '_ztec_team_player', true); ?>
                
                    <div class="teamplayer_main_wrapper">
                        <?php if(!empty($getplayer_data)){
                         foreach($getplayer_data as $key_player=>$val_player){?>
                            <div id="show_1" class="show_inline_section">
                                <p><?php esc_html_e("Name:", ZTEC_TEXT_DOMAIN);?></p><input style="width: 30%;"  type="text" name="player_data[player_name][]" value="<?php echo !empty($val_player['player_name'])?$val_player['player_name']:'' ?>" placeholder="Enter Player Name"/>
                                <p><?php esc_html_e("DOB:", ZTEC_TEXT_DOMAIN);?></p><input style="width: 30%;"  type="date" name="player_data[player_dob][]" value="<?php echo !empty($val_player['player_dob'])?$val_player['player_dob']:'' ?>" placeholder="Date of Birth"/>
                                <a  class="player_remove_button button" id="removebtn_<?php echo $key_player?>" style="margin-left: 11px;"><?php esc_html_e("Remove", ZTEC_TEXT_DOMAIN);?></a>
                            </div>
                            <?php }
                        }
                        else{
                        ?>
                          <div id="show_0" class="show_inline_section">
                          <p><?php esc_html_e("Name:", ZTEC_TEXT_DOMAIN);?></p><input style="width: 30%;"  type="text" name="player_data[player_name][]" value="" placeholder="Enter Player Name"/>
                          <p><?php esc_html_e("DOB:", ZTEC_TEXT_DOMAIN);?></p><input style="width: 30%;"  type="date" name="player_data[player_dob][]" value="" placeholder="Date of Birth"/>
                          </div>
                        <?php    
                        }
                            ?>
                    </div>
                    
                    <a class="pt-5 player_add_button button" title="Add field"><?php esc_html_e("Add More", ZTEC_TEXT_DOMAIN);?></a>
               
            </td>
        </tr>
    </tbody>
</table>
<script type="text/javascript">
            jQuery(document).ready(function(){
                var holder = <?php echo isset($key_player) ? $key_player : 0; ?>
                // var maxField = 10; //Input fields increment limitation
                var addButton = jQuery('.player_add_button'); //Add button selector
                var wrapper = jQuery('.teamplayer_main_wrapper'); //Input field wrapper
                var initial_cast = <?php echo (isset($getplayer_data['player_data'][0]) && count($getplayer_data['player_data'][0])>0 ? count($getplayer_data['player_data'][0]):1)?>; //Initial field counter is 1 
                
                function fieldHTML(count){
                    return '<div id="show_'+count+'" class="show_inline_section"><p>Name:</p><input style="width: 30%;"  type="text" name="player_data[player_name][]" value="" placeholder="Enter Player Name"/> <p>DOB:</p><input style="width: 30%;"  type="date" name="player_data[player_dob][]" value="" placeholder="Date of Birth"/> <a  class="player_remove_button button" id="removebtn_'+count+'" style="margin-left: 11px;">Remove</a></div>'; //New input field html
                }
                //Once add button is clicked
                jQuery(addButton).click(function(){
                    holder=holder+1; //Increment field counter 
                        jQuery(wrapper).append(fieldHTML(holder)); //Add field html
                 
                });
                
                //Once remove button is clicked
                jQuery(wrapper).on('click', '.player_remove_button', function(remove_field){
                    remove_field.preventDefault();
                    jQuery(this).parent('div').remove(); //Remove field html
                   
                });
                
                   
                    
               
            });
</script>
