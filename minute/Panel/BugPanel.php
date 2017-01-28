<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 7/8/2016
 * Time: 7:57 PM
 */
namespace Minute\Panel {

    use App\Model\MBug;
    use Minute\Event\ImportEvent;

    class BugPanel {
        public function adminDashboardPanel(ImportEvent $event) {
            $count  = MBug::distinct()->count(['type']);
            $panels = [['type' => 'site', 'title' => 'Bugs', 'stats' => "$count types", 'icon' => 'fa-bug', 'priority' => 3, 'href' => '/admin/bugs', 'cta' => 'View bugs..', 'bg' => 'bg-aqua']];

            $event->addContent($panels);
        }
    }
}