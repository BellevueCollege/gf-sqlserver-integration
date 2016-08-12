
<h3><span><i class="fa fa-database"></i> BC SQL Server Data Integration</span></h3>
<p>
    If the form data will be synced with SQL Server, select the correct database model for the form.
<?php 

if ( isset( $_POST['gfsi_save_settings'] ) ) {
    if ( check_admin_referer( NONCE_ACTION, NONCE_FIELD ) ) {

        //then save model selection
        $form["gfsi_model"] = $_POST["gfsi_custom_setting_mssql_model"];

        $result = GFFormsModel::update_form_meta( $form_id, $form );
        if ( false === $result ) {
            echo '<div id="message" class="notice notice-error fade"><p><strong>Data integration settings could not be updated.</strong></p></div>';
            GFCommon::log_error("BC SQL Server Integration plugin: can't update_form_meta, ". $result );
		} else {
            //otherwise assume it all went according to plan
			echo '<div id="message" class="updated fade"><p><strong>Data integration settings updated!</strong></p></div>';
        }
    }
}
?> 
        
<form method="post">
    <table class="gforms_form_settings" cellspacing="0" cellpadding="0">
        <tr>
            <th>
                <label for="gfsi_custom_setting_mssql_model">Database mapping model</label>
            </th>
            <td>
                <select name="gfsi_custom_setting_mssql_model">
                    <option value=""></option>
                    <?php 
                    //$model_setting = get_option('gfsi_model_settings');
                    //$cur_setting = null !== get_option(rgar($form, 'gfsi_model_setting') ? rgar($form, 'gfsi_model_setting') : ""; 
                    foreach ( SQLSERVER_MODELS as $model ) {
                        $selected = ( isset($form["gfsi_model"]) && $model == $form["gfsi_model"]) ? "selected" : "";
                    ?>
                        <option value="<?php echo $model; ?>" <?php echo $selected; ?> ><?php echo $model; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </td>
        </tr>
    </table>
    <?php wp_nonce_field( NONCE_ACTION, NONCE_FIELD ); ?>
    <input type="submit" id="gfsi_save_settings" name="gfsi_save_settings" value="Update integration settings" class="button-primary gfbutton" />
</form>