# Gravity Forms SQL Server Integration WordPress Plugin

This plugin allows for the moving of data from a submitted Gravity Forms form to SQL Server. Based on the submitted form entry, it fills out the appropriate data model and moves the form data and related transaction data to SQL Server (or, easily, an alternate external database).

The plugin currently hooks to the `gform_post_payment_action` action. A data model class must exist for each form to which you want to attach SQL Server integration.

## Use
Installation of the plugin adds an additional submenu titled _BC SQL Server Data Integration_ to the settings for each individual form in Gravity Forms. On that submenu page, select the data model that maps to your form then save to update the data integration settings.

## Add a new data model

 - Create the new data model - create a new class file for your data model and include in the _classes_ directory. Likely one of the existing models could serve as a template.
 - Include in the main plugin file `switch` - in `gf-sqlserver-integration.php` require the PHP class file and also add the class to the `switch` statement that determines which data model to use.
 - Add the new class name to the `SQLSERVER_MODELS` global variable (comma-delimited list) in the configuration file.


## Troubleshooting
If you've installed the plugin and aren't seeing your data in the external DB, try the following:

- _Check the configuration_ - Check that the database connection info is correct.
- _Check that a data model is selected for the form_ - On the BC SQL Server Integration submenu page for the form, ensure that a data model is selected.
- _Ensure a payment feed exists for the form(s)_ - Because this plugin attaches to the post payment action (`gform_post_payment_action`), a payment feed must exist for each form and be active. As such you need to install the Authorize.Net add-on to Gravity Forms then use the Authorize.Net submenu to create and activate a feed for each form.
- _Check that the form ID for the Gravity Forms form exists in the Forms table in SQL Server_ - (This is specific to the current BC data constraints and should only be an issue in dev or test environments.) Ensure that the form ID for your form is in the Forms table in SQL Server.
