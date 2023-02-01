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
    </tbody>
</table>
