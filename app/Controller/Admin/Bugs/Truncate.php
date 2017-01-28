<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller\Admin\Bugs {

    use App\Model\MBug;

    class Truncate {

        public function index() {
            MBug::truncate();
        }
    }
}