<?php

  /**
  * @author: Kevin Olinger, 2016-04-28
  * @copyright: 2016+ Fallen Studios
  *
  * Last modified: 2016-04-28
  */

  namespace core\system;
  use core\Core;

  class Utils {

    public function checkEmail($email): bool {
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)) Core::End("Invalid email address given.", 17);

      Core::getDB()->query("SELECT accountID FROM ". DBPREFIX ."account WHERE email = :email LIMIT 1");
      Core::getDB()->bind(":email", $email);
      Core::getDB()->execute();

      if(Core::getDB()->rowCount() == 1) return true;
      else return false;
    }

    public function checkUsername($username): bool {
      if(!preg_match("/^[a-zA-Z ]*$/", $username)) Core::End("Invalid username given.", 18);

      Core::getDB()->query("SELECT accountID FROM ". DBPREFIX ."account WHERE username = :username LIMIT 1");
      Core::getDB()->bind(":username", $username);
      Core::getDB()->execute();

      if(Core::getDB()->rowCount() == 1) return true;
      else return false;
    }

  }
