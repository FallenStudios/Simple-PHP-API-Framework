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
  use core\system\Parameters;
  use core\system\Systemtoken;
  use core\system\Utils;

  class System {

    protected static $paraObj = null;
    protected static $tokenObj = null;
    protected static $utilsObj = null;

    public function __construct() {
      $this->initPara();
      $this->initToken();
      $this->initUtils();
    }

    protected function initPara() { self::$paraObj = new Parameters(); }
    protected function initToken() { self::$tokenObj = new Systemtoken(); }
    protected function initUtils() { self::$utilsObj = new Utils(); }

    public static final function getParams(): Parameters { return self::$paraObj; }
    public static final function getToken(): Systemtoken { return self::$tokenObj; }
    public static final function getUtils(): Utils { return self::$utilsObj; }

  }
