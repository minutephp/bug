<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 8/6/2016
 * Time: 1:51 PM
 */
namespace Minute\Bug {

    use App\Model\MBug;
    use Carbon\Carbon;
    use Minute\Config\Config;
    use Minute\Error\BasicError;
    use Minute\Event\Dispatcher;
    use Minute\Event\RawMailEvent;
    use Minute\Routing\Router;
    use Minute\Utils\PathUtils;
    use Throwable;

    class BugLogger {
        /**
         * @var Dispatcher
         */
        private $dispatcher;
        /**
         * @var Config
         */
        private $config;
        /**
         * @var Router
         */
        private $router;
        /**
         * @var PathUtils
         */
        private $utils;

        /**
         * BugHandler constructor.
         *
         * @param Dispatcher $dispatcher
         * @param Config $config
         * @param Router $router
         * @param PathUtils $utils
         */
        public function __construct(Dispatcher $dispatcher, Config $config, Router $router, PathUtils $utils) {
            $this->dispatcher = $dispatcher;
            $this->config     = $config;
            $this->router     = $router;
            $this->utils      = $utils;
        }

        public function log(Throwable $e) {
            $ignores = $this->config->get('private/errors/ignore', ["AuthError"]);
            $class   = $this->utils->filename(get_class($e));

            if (!in_array($class, $ignores)) {
                try {
                    $route     = $this->router->getLastMatchingRoute();
                    $routeInfo = !empty($route) ? ['url' => $route->getPath(), 'method' => $route->getMethods()[0], 'params' => $route->getDefaults()] : [];

                    $data    = array_merge($routeInfo, ['http' => ['GET' => $_GET, 'POST' => $_POST, 'SERVER' => $_SERVER, 'COOKIE' => $_COOKIE]]);
                    $traces  = array_merge([['file' => $e->getFile(), 'line' => $e->getLine()]], $e->getTrace());
                    $ignores = ['Catcher', 'App'];

                    list($file, $line) = [$e->getFile(), $e->getLine()];

                    foreach ($traces as $trace) {
                        if (!empty($trace['file']) && !in_array($this->utils->filename($trace['file']), $ignores)) {
                            list($file, $line) = [$trace['file'], $trace['line']];
                            break;
                        }
                    }

                    if (!empty($file) && !empty($line)) {
                        if ($contents = file_get_contents($file)) {
                            $statements = explode("\n", $contents);

                            for ($i = max(0, $line - 3); $i < min(count($statements), $line + 3); $i++) {
                                $lines[$i + 1] = $statements[$i];
                            }
                        }

                        $sev = $e instanceof BasicError ? $e->getSeverity() : 'error';
                        $bug = ['created_at' => Carbon::now(), 'data_json' => json_encode($data), 'snapshot_json' => json_encode($lines ?? []), 'severity' => $sev];

                        MBug::unguard();
                        MBug::updateOrCreate(['type' => $class, 'message' => substr($e->getMessage(), 0, 249), 'file' => substr(basename($file), 0, 49), 'line' => $line], $bug)
                            ->increment('occurrence');
                    }
                } catch (Throwable $e) {
                }
            }
        }
    }
}