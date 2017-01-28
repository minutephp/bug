<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 11/5/2016
 * Time: 11:04 AM
 */
namespace Minute\Todo {

    use App\Model\MBug;
    use Minute\Config\Config;
    use Minute\Event\ImportEvent;

    class BugTodo {
        /**
         * @var TodoMaker
         */
        private $todoMaker;

        /**
         * MailerTodo constructor.
         *
         * @param TodoMaker $todoMaker - This class is only called by TodoEvent (so we assume TodoMaker is be available)
         */
        public function __construct(TodoMaker $todoMaker, Config $config) {
            $this->todoMaker = $todoMaker;
        }

        public function getTodoList(ImportEvent $event) {
            $todos[] = ['name' => 'Review and clear all pending bug reports', 'status' => MBug::where('severity', '<>', 'warning')->count() == 0 ? 'complete' : 'incomplete', 'link' => '/admin/bugs'];

            $event->addContent(['Bug' => $todos]);
        }
    }
}