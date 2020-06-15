<?php

    namespace App;

    use Monolog\Handler\StreamHandler;
    use Monolog\Logger;

    class Log {

        //Singleton Design Pattern
        private static $_logger = null;

        private static function getLogger() {
            if(!self::$_logger) {
                //new Logger(name);
                self::$_logger = new Logger('App Log');
            }
            return self::$_logger;
        }

        public static function logError($error) {
            //Where go to save the logs
            self::getLogger()->pushHandler(new StreamHandler('../logs/application.log', Logger::ERROR));
            //Save the log
            self::getLogger()->addError($error);
        }

        public static function logInfo($info) {
            //Where go to save the logs
            self::getLogger()->pushHandler(new StreamHandler('../logs/application.log', Logger::INFO));
            //Save the log
            self::getLogger()->addInfo($info);
        }
    }