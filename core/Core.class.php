<?php

  /**
  * @author: Kevin Olinger, 2016-04-27
  * @copyright: 2016+ Fallen Studios
  *
  * Last modified: 2016-04-28
  */

  /*

    The MIT License (MIT)

    Copyright (c) 2016+ Fallen Studios <https://fallenstudios.org>
    Copyright (c) 2016+ Kevin Olinger <https://kevyn.lu> <https://kevinolinger.net>

    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions:

    The above copyright notice and this permission notice shall be included in all
    copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
    SOFTWARE.

  */

  /**
  * TODO:
  * - Add license
  * - Disable error reporting, later in productive environement
  * - Check if the connection is secured (HTTPS/SSL)
  * - Define return types
  * - Welcome email at registering
  * - Review core\system\Parameters->checkParam()
  */

  namespace core;
  use core\database\Database;
  use core\system\System;

  spl_autoload_register(array(__NAMESPACE__ ."\Core", "autoload"));

  class Core {

    protected $component = null;
    protected $function = null;

    protected static $dbObj = null;
    protected static $sysObj = null;

    public function __construct() {
      //Start classes initializing
      $this->initDB();
      $this->initSys();

      $this->component = $_GET["component"] ?? null;
      $this->function = $_GET["function"] ?? null;

      self::getAPI();
      self::getDB()->close();
    }

    protected function initDB() {
      $dbHost = $dbUser = $dbPass = $dbName = "";
      require_once("config/db.inc.php");

      self::$dbObj = new Database($dbHost, $dbUser, $dbPass, $dbName);

      define("DBPREFIX", $dbPrefix);
    }

    protected function initSys() {
      self::$sysObj = new System();
    }

    //Return classes
    public static final function getDB(): Database { return self::$dbObj; }
    public static final function getSys(): System { return self::$sysObj; }

    protected function getAPI() {
      if($this->component == null) self::End("No component given.", 6);
      if($this->function == null) self::End("No function given.", 7);
      if(!file_exists("core/api/". $this->component)) self::End("Invalid component given.", 8);

      $requested = ucFirst($this->function) ."API";
      $requestedClass = "core\api\\". $this->component ."\\". $requested;

      if(!file_exists("core/api/". $this->component ."/". $requested .".class.php")) self::End("Invalid function given.", 9);

      new $requestedClass();
    }

    public static final function autoload($className) {
      $classOriginal = $className;

      if(strtok($classOriginal, "\\") != "core") self::End("'". $classOriginal ."' not in allowed path.", 2);
      if(!file_exists($classOriginal)) $className .= ".php";
      if(!file_exists($className)) $className = $classOriginal .".class.php";
      if(!file_exists($className)) $className = str_replace("\\", "/", $className);
      if(!file_exists($className)) self::End("'". $classOriginal ."' does not exist.", 3);

      require_once($className);
    }

    public static function End($message = "undefined", $code = 0) {
      header_remove('Content-Type');
      header('Content-Type: application/json');

      exit(
        json_encode(
          array(
            "status" => "error",
            "code" => $code,
            "response" => get_class() ." >> ". debug_backtrace()[1]['function'] ." >> ". $message
          ), JSON_PRETTY_PRINT
        )
      );
    }

    public static function Finish($message = "undefined") {
      header_remove('Content-Type');
      header('Content-Type: application/json');

      exit(
        json_encode(
          array(
            "status" => "success",
            "response" => $message
          ), JSON_PRETTY_PRINT
        )
      );
    }

  }
