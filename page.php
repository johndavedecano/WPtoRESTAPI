<div class="wrap">

    <h2>CRM Integration Settings</h2>
    <p>Please specify the url parameters for each custom fields.</p>
    <?php if (isset($_POST['submit'])):?>
        <div id="setting-error-settings_updated" class="updated settings-error">
            <p><strong>Exported to <?php echo get_option('api_field_url', 'http://yourdomain.com');?></strong></p>
        </div>
    <?php endif;?>
    <form method="post" action="/wp-admin/admin.php?page=crm_integration">
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="blogname">API url</label></th>
                    <td><input name="api_url" type="text" id="api_url" value="<?php echo get_option('api_field_url', 'http://yourdomain.com');?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="blogname">ID</label></th>
                    <td><input name="api_id" type="text" id="api_id" value="<?php echo get_option('api_field_id', 'id');?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="blogname">Name</label></th>
                    <td><input name="api_name" type="text" id="api_name" value="<?php echo get_option('api_field_name', 'name');?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="blogname">Email</label></th>
                    <td><input name="api_email" type="text" id="api_email" value="<?php echo get_option('api_field_email', 'email');?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="blogname">Status</label></th>
                    <td><input name="api_status" type="text" id="api_status" value="<?php echo get_option('api_field_status', 'status');?>" class="regular-text"></td>
                </tr>
            </tbody>
        </table>
        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Settings">
        </p>
    </form>
</div>
