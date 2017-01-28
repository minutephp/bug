<?php

/** @var Router $router */
use Minute\Model\Permission;
use Minute\Routing\Router;

$router->get('/admin/bugs', null, 'admin', 'm_bugs[5] as bugs ORDER by created_at DESC')
       ->setReadPermission('bugs', 'admin')->setDefault('bugs', '*');
$router->post('/admin/bugs', null, 'admin', 'm_bugs as bugs')
       ->setAllPermissions('bugs', 'admin');

$router->post('/admin/bugs/truncate', 'Admin/Bugs/Truncate', 'admin')
    ->setDefault('_noView', true);

$router->get('/admin/bugs/edit/{bug_id}', 'Admin/Bugs/Edit', 'admin', 'm_bugs[bug_id] as bugs', 'm_configs[type][1] as configs')
       ->setReadPermission('bugs', 'admin')->setReadPermission('configs', 'admin')->setDefault('type', 'private');
$router->post('/admin/bugs/edit/{bug_id}', null, 'admin', 'm_bugs as bugs', 'm_configs as configs')
       ->setAllPermissions('bugs', 'admin')->setAllPermissions('configs', 'admin');