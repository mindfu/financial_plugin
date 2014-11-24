<?php
if (!defined('WP_UNINSTALL_PLUGIN'))
    exit ();
//delete_option ('financial_plugin_function');

if (function_exits('register_uninstall_hook')) {
    //register_uninstall_hook(__FILE__, 'financial_plugin_uninstall');
}