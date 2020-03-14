<?php
  Namespace __PROJECT__\System;

  use \Medoo\Medoo;
  use \__PROJECT__\System\MedooCustom;

  class Database extends Medoo {

    /**
     * Updates the database if the record exists
     * @param  String $table The table name
     * @param  Array  $where The where statement
     * @param  Array  $data  The data to update/create with
     * @return Void
     */
    public function updateOrCreate(String $table, Array $where, Array $data) {
      if($this->has($table, $where)) {
        $this->update($table, $data, $where);
      } else {
        $this->insert($table, array_merge($where, $data));
      }
    }

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
