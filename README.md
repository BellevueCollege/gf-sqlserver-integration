## Gravity Forms SQL Server Integration WordPress Plugin

This plugin allows for the moving of data from a submitted Gravity Forms form to SQL Server. Based on the submitted form entry, it fills out the appropriate data model and moves the form data and related transaction data to SQL Server (or, easily, an alternate external database).

The plugin currently hooks to the `gform_post_payment_action` action. A data model class must exist for each form to which you want to attach SQL Server integration.

###Use
Installation of the plugin adds an additional submenu titled _BC SQL Server Data Integration_ to the settings for each individual form in Gravity Forms. On that submenu page, select the data model that maps to your form then save to update the data integration settings.

###Add a new data model

 - Create the new data model - create a new class file for your data model and include in the _classes_ directory. Likely one of the existing models could serve as a template.
 - Include in the main plugin file `switch` - in `gf-sqlserver-integration.php` require the PHP class file and also add the class to the `switch` statement that determines which data model to use.
 - Add the new class name to the `SQLSERVER_MODELS` global variable (comma-delimited list) in the configuration file.


####A note on PHP MSSQL drivers for Ubuntu

The SQL Server side of our setup mostly uses nvarchars. As such, encoding of data has been found to be in issue depending on the driver/Ubuntu MSSQL package.  Without modifications, **this plugin currently only works with PHP5 using the php5-mssql package available on Ubuntu**. 

In tests with Ubuntu/PHP7 and the available php7.0-sybase package, data with special characters came across mangled unless the encoding was first specifically encoded to UTF-16.  It appears the php5-mssql package does this translation implicitly while php7.0-sybase does not. 

When/if we look at moving to a PHP7 setup, hopefully the php7.0-sybase package will have had some time to go through some update iterations.  If implicit translation still isn't happening, you can use the `check_encoding()` function in the `Utility` class. When passed an array of the input data (i.e. the array you will pass to the prepared statement for execution), it will loop through each item, check the encoding, and update to UTF-16 if necessary. It will change the encoding of any UTF-8 items (i.e. there's a special char) to UTF-16. If it detects a new line character, it will also change the encoding of the item to UTF-16. If you come across additional encoding scenarios, add them to this function.