<?php

  /**
  * @author: Kevin Olinger, 2016-04-28
  * @copyright: 2016+ Fallen Studios
  *
  * Last modified: 2016-04-28
  */

  namespace core\system;
  use core\Core;

  class Token {

    protected $checked = false;

    protected $token = null;
    protected $tokenOptions = array();
    protected $tokenColumns = array();
    protected $tokenType = "usertoken";
    protected $tokenTable = "token";

    public final function setToken($token) { $this->token = $token; }
    public final function setTokenColumns($columns) { $this->tokenColumns = $columns; }
    public final function setTokenType($type) { $this->tokenType = $type; }
    public final function setTokenTable($table) { $this->tokenTable = $table; }

    protected function getToken() {
      if($this->token == null) Core::End(ucfirst($this->tokenType) ." required, but not given.", 12);

      Core::getDB()->query("SELECT ". implode(", ", $this->tokenColumns) ." FROM ". DBPREFIX . $this->tokenTable ." WHERE token = :token LIMIT 1");
      Core::getDB()->bind(":token", $this->token);
      $result = Core::getDB()->single();

      if(Core::getDB()->rowCount() != 1) Core::End("Invalid systemtoken given!", 13);

      $this->tokenOptions = $result;
      $this->checked = true;
    }

    public function checkPermission($permission): bool {
      if(!$this->checked) $this->getToken();

      $permission = "perm". ucfirst($permission);

      if(!array_key_exists($permission, $this->tokenOptions)) return false;
      else {
        if($this->tokenOptions[$permission] == 1) return true;
        else return false;
      }
    }

  }
