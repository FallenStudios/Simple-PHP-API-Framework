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

  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on') {
    header_remove('Content-Type');
    header('Content-Type: application/json');

    exit(
      json_encode(
        array(
          "status" => "error",
          "code" => 5,
          "message" => "You tried to access the API over a unsecure connection."
        ), JSON_PRETTY_PRINT
      )
    );
  }

  if(version_compare(PHP_VERSION, '7.0') < 0) {
    header_remove('Content-Type');
    header('Content-Type: application/json');

    exit(
      json_encode(
        array(
          "status" => "error",
          "code" => 1,
          "message" => "Simple PHP API Framework requires PHP 7.0 (or higher) to run."
        ), JSON_PRETTY_PRINT
      )
    );
  }

  require_once("core/Core.class.php");
  new core\Core();
