<?php
/**
 * Created by: MinutePHP Framework
 */
namespace App\Model {

    use Minute\Model\ModelEx;

    class MBug extends ModelEx {
        protected $table      = 'm_bugs';
        protected $primaryKey = 'bug_id';
    }
}