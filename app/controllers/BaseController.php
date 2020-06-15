<?php

    namespace App\Controllers;

    use Twig_Loader_Filesystem;

    class BaseController {

        protected $templateEngine;
        
        public function __construct() {
            //Initialize twig and load the files system
            $loader = new Twig_Loader_Filesystem('../views');
            $this->templateEngine = new \Twig_Environment($loader, [
                'debug' => true,
                'cache' => false
            ]);

            //Add filter
            $this->templateEngine->addFilter(new \Twig_SimpleFilter('url', function ($path) {
                return BASE_URL . $path;
            }));
        }
        public function render($fileName, $data = []) {
            return $this->templateEngine->render($fileName, $data);
        }
    }