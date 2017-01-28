<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 8/6/2016
 * Time: 1:25 PM
 */
namespace Minute\Bug {

    use Exception;
    use Minute\Debug\Debugger;
    use Minute\Error\BasicError;
    use Minute\Error\PhpError;
    use Minute\Event\ExceptionEvent;
    use Throwable;

    class Catcher {
        private $debugger;
        /**
         * @var BugLogger
         */
        private $bugLogger;

        /**
         * Catcher constructor.
         *
         * @param Debugger $debugger
         * @param BugLogger $bugLogger
         */
        public function __construct(Debugger $debugger, BugLogger $bugLogger) {
            $this->debugger  = $debugger;
            $this->bugLogger = $bugLogger;
        }

        public function register() {
            set_error_handler([$this, 'handler']);
        }

        public function handler(int $code, string $msg, string $file, int $line, array $context) {
            if (!(error_reporting() & $code)) {
                return;
            }

            $severity = (($code === E_ERROR) || ($code === E_COMPILE_ERROR) || ($code === E_PARSE) || ($code === E_USER_ERROR)) ? BasicError::ERROR : BasicError::WARNING;
            $this->log(new ExceptionEvent(new PhpError($msg, $severity, $code)));
        }

        public function log(ExceptionEvent $event) {
            $this->bugLogger->log($event->getError());
        }
    }
}