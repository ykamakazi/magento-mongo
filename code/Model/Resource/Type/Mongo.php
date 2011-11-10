<?php

class Cm_Mongo_Model_Resource_Type_Mongo extends Mage_Core_Model_Resource_Type_Abstract
{

  /**
   * Get the Mongo database adapter
   *
   * @param Mage_Core_Model_Config_Element $config Connection config
   * @return Mongo_Database
   */
  public function getConnection(Mage_Core_Model_Config_Element $config)
  {
    require_once 'mongodb-php-odm'.DS.'classes'.DS.'json.php';
    require_once 'mongodb-php-odm'.DS.'classes'.DS.'mongo'.DS.'database.php';
    require_once 'mongodb-php-odm'.DS.'classes'.DS.'mongo'.DS.'collection.php';

    $conn = Mongo_Database::instance((string)$config->config, $config);

    // Set profiler
    $conn->set_profiler(array($this, 'start_profiler'), array($this, 'stop_profiler'));

    return $conn;
  }

  public function start_profiler($group, $query)
  {
    $key = "$group::$query";
    Cm_Mongo_Profiler::start($key);
    return $key;
  }

  public function stop_profiler($key)
  {
    Cm_Mongo_Profiler::stop($key);
  }

}
