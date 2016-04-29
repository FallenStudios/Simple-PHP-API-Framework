<?php

  /**
  * @author: Kevin Olinger, 2016-04-28
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

  namespace core\system;
  use core\Core;

  class Token {

    protected $checked = false;

    protected $token = null;
    protected $tokenOptions = array();
    protected $tokenColumns = array();
    protected $tokenType = "usertoken";
    protected $tokenTable = "uno_token";

    public final function setToken($token) { $this->token = $token; }
    public final function setTokenColumns($columns) { $this->tokenColumns = $columns; }
    public final function setTokenType($type) { $this->tokenType = $type; }
    public final function setTokenTable($table) { $this->tokenTable = $table; }

    protected function getToken() {
      if($this->token == null) Core::End(ucfirst($this->tokenType) ." required, but not given.", 12);

      Core::getDB()->query("SELECT ". implode(", ", $this->tokenColumns) ." FROM ". $this->tokenTable ." WHERE token = :token LIMIT 1");
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
