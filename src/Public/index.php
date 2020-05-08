<?php

  Namespace __PROJECT__;

  use \__PROJECT__\Controllers\Controller;
  use \__PROJECT__\System\Settings;
  use \__PROJECT__\Routes\WebRoutes;
  use \__PROJECT__\System\Database;
  use \Dotenv\Dotenv;
  use \Slim\Views\Twig;
  use \Slim\Views\TwigExtension;
  use \Slim\Views\TwigMiddleware;
  use \Slim\Factory\AppFactory;
  use \DI\Container;
  use \Psr\Http\Message\ServerRequestInterface as Request;
  use \Psr\Http\Message\ResponseInterface as Response;

  require '../../vendor/autoload.php';

  class __PROJECT__ {
    /**
     * Loads all the important essential variables
     * @return Void
     */
    private function loadEssentials() {
      //Start session, set time and autoloader
      session_start();
      date_default_timezone_set('UTC');
      spl_autoload_register('self::classAutoloader');

      //Load .env
      $dotenv = Dotenv::createImmutable(__DIR__, '../.env');
      $dotenv->load();

      //Set Dev mode
      if(getenv('DEV_MODE')) {
        Settings::devMode();
      }
    }

    /**
     * This will require a class automatically
     * @param  Class $class The needed class
     */
    private static function classAutoloader($class) {
      $class = str_replace("__PROJECT__\\", "", $class);
      $class = str_replace("\\", "/", $class);
      $class = "../".$class.".php";
      require_once($class);
    }

    /**
     * Starts the __PROJECT__ API Service
     * @return Void
     */
    public static function start() {
      //Load Essential variables
      self::loadEssentials();

      //Create Container
      $container = new Container();
      AppFactory::setContainer($container);

      //Create Cache
      if(!is_dir('../View/Cache')) {
        if(!mkdir('../View/Cache')) {
          die("Couldn't create Cache directory");
        }
      }

      //Set view in Container
      $container->set('view', function() {
          return new Twig('../View', [
            'debug' => getenv('DEV_MODE'),
            'cache' => '../View/Cache'
          ]);
      });

      //Set the database in container
      $container->set('database', function () {
        return Database::getDatabase();
      });

      //Create App
      $app = AppFactory::create();

      //Add some twig middleware
      $app->add(TwigMiddleware::createFromContainer($app));
      $app->add($app->addErrorMiddleware(true, true, true));

      //If member session exists sign in
      if(isset($_SESSION['MEMBER'])) {
        $view->getEnvironment()->addGlobal('user', $_SESSION['MEMBER']);
      }

      //Start an instance of controller and routing
      Controller::createInstance($app);
      WebRoutes::start($app);

      //Start the app
      $app->run();
    }
  }

  /**
   * Starts Everything
   * @var __PROJECT__
   */
  __PROJECT__::start();
