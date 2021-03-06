<?php

  Namespace __PROJECT__\Controllers;

  use __PROJECT__\Controllers\Controller;

  class HomeController extends Controller {
    /**
     * Shows the home page
     * @param  Request  $request  The request
     * @param  Response $response The response
     * @param  Array    $args     Args for the page if any
     * @return Twig               The view
     */
    public static function getHome($request, $response, $args) {
      $views = self::$db->get('stats', '*')['views'];
      return self::render($response, 'home', [
        'views' => $views
      ]);
    }
}
