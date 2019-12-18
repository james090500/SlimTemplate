<?php
  Namespace __PROJECT__\Routes;

  use \__PROJECT__\Controllers\HomeController;

  class WebRoutes {

    public static function start($app) {
      //General Pages
      $app->get('/', [ HomeController::class, 'getHome' ]);
    }
  }
