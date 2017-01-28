<?php

/** @var Binding $binding */
use Minute\Bug\Catcher;
use Minute\Event\AdminEvent;
use Minute\Event\AppEvent;
use Minute\Event\Binding;
use Minute\Event\ExceptionEvent;
use Minute\Event\TodoEvent;
use Minute\Menu\BugMenu;
use Minute\Panel\BugPanel;
use Minute\Todo\BugTodo;

$binding->addMultiple([

    //bug
    ['event' => AppEvent::APP_INIT, 'handler' => [Catcher::class, 'register']],
    ['event' => ExceptionEvent::EXCEPTION_UNHANDLED, 'handler' => [Catcher::class, 'log']],

    ['event' => AdminEvent::IMPORT_ADMIN_MENU_LINKS, 'handler' => [BugMenu::class, 'adminLinks']],
    ['event' => AdminEvent::IMPORT_ADMIN_DASHBOARD_PANELS, 'handler' => [BugPanel::class, 'adminDashboardPanel']],

    //tasks
    ['event' => TodoEvent::IMPORT_TODO_ADMIN, 'handler' => [BugTodo::class, 'getTodoList']],
]);