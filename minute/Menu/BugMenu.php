<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 7/8/2016
 * Time: 7:57 PM
 */
namespace Minute\Menu {

    use Minute\Event\ImportEvent;

    class BugMenu {
        public function adminLinks(ImportEvent $event) {
            $links = [
                'bugs' => ['title' => 'Bugs', 'icon' => 'fa-bug', 'priority' => 4, 'parent' => 'expert', 'href' => '/admin/bugs']
            ];

            $event->addContent($links);
        }
    }
}