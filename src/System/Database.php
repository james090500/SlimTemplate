<?php
  Namespace __PROJECT__\System;

  use \Medoo\Medoo;
  use \__PROJECT__\System\MedooCustom;

  class Database extends Medoo {

    /**
     * Returns a single instance of the database
     * @return Meedo The DB Instance
     */
    public static function getDatabase() {
      return new Database([
        'database_type' => $_ENV['DB_TYPE'],
        'database_name' => $_ENV['DB_NAME'],
        'server' => $_ENV['DB_HOST'],
        'username' => $_ENV['DB_USERNAME'],
        'password' => $_ENV['DB_PASSWORD'],
      ]);
    }
  }
