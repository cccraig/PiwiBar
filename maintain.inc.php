<?php

defined('PHPWG_ROOT_PATH') or die('Hacking attempt!');


/**
 * This class is used to expose maintenance methods to the plugins manager
 * It must extends PluginMaintain and be named "PLUGINID_maintain"
 * where PLUGINID is the directory name of your plugin
 */
class PiwiBar_maintain extends PluginMaintain
{

  /**
   * plugin installation
   *
   * perform here all needed step for the plugin installation
   * such as create default config, add database tables,
   * add fields to existing tables, create local folders...
   */
  function install($plugin_version, &$errors=array())
  {
    $query = 'INSERT INTO ' . CONFIG_TABLE . ' (param,value,comment) VALUES ("PiwiBar","","Notification bar configuration values");';

    pwg_query($query);

  }

  function deactivate()
  {
    // Do nothing
  }

  function update($old_version, $new_version, &$errors=array())
  {
    // Do nothing
  }

  function uninstall()
  {
    conf_delete_param('PiwiBar');
  }

}
