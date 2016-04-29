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

  class Utils {

    public function checkEmail($email): bool {
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)) Core::End("Invalid email address given.", 17);

      Core::getDB()->query("SELECT accountID FROM uno_account WHERE email = :email LIMIT 1");
      Core::getDB()->bind(":email", $email);
      Core::getDB()->execute();

      if(Core::getDB()->rowCount() == 1) return true;
      else return false;
    }

    public function checkUsername($username): bool {
      if(!preg_match("/^[a-zA-Z ]*$/", $username)) Core::End("Invalid username given.", 18);

      Core::getDB()->query("SELECT accountID FROM uno_account WHERE username = :username LIMIT 1");
      Core::getDB()->bind(":username", $username);
      Core::getDB()->execute();

      if(Core::getDB()->rowCount() == 1) return true;
      else return false;
    }

  }
