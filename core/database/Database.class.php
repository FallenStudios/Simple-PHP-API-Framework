<?php

  /**
   * @author: Kevin Olinger, 2016-04-27
   * @copyright: 2016+ Fallen Studios
   *
   * Last modified: 2016-04-27
   *
   * Todo:
   *  SQLite Support
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

   namespace core\database;
   use core\Core;

   class Database {

     protected $dbHandler;
     protected $stmt;

     public function __construct($dbHost, $dbUser, $dbPass, $dbName) {
       $dataSource = "mysql:host=". $dbHost .";dbname=". $dbName;
       $pdoAttributes = array(
         \PDO::ATTR_PERSISTENT => true,
         \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
       );

       try { $this->dbHandler = new \PDO($dataSource, $dbUser, $dbPass, $pdoAttributes); }
       catch(\PDOException $ex) { Core::End($ex->getMessage(), 4); }
     }

     public function query($query) {
       $this->stmt = $this->dbHandler->prepare($query);
     }

     public function bind($param, $value, $type = null) {
       if(is_null($type)) {
         switch(true) {

           case is_int($value):
             $type = \PDO::PARAM_INT;
             break;

           case is_bool($value):
             $type = \PDO::PARAM_BOOL;
             break;

           case is_null($value):
             $type = \PDO::PARAM_NULL;
             break;

           default:
             $type = \PDO::PARAM_STR;

        }
      }

      $this->stmt->bindValue($param, $value, $type);
    }

    public function execute() {
      return $this->stmt->execute();
    }

    public function resultset(): array {
      $this->execute();

      return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function single() {
      $this->execute();

      return $this->stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function rowCount(): int {
      return $this->stmt->rowCount();
    }

    public function lastInsertId(): int {
      return $this->dbHandler->lastInsertId();
    }

    public function beginTransaction() {
      return $this->dbHandler->beginTransaction();
    }

    public function endTransaction() {
      return $this->dbHandler->commit();
    }

    public function cancelTransaction() {
      return $this->dbHandler->rollBack();
    }

    public function debugDumpParams() {
      return $this->stmt->debugDumpParams();
    }

    public function close() {
      unset($this->dbHandler);
    }

  }
