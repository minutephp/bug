<?php
use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class BugInitialMigration extends AbstractMigration
{
    public function change()
    {
        // Automatically created phinx migration commands for tables from database minute

        // Migration for table m_bugs
        $table = $this->table('m_bugs', array('id' => 'bug_id'));
        $table
            ->addColumn('created_at', 'date', array())
            ->addColumn('type', 'string', array('limit' => 50))
            ->addColumn('message', 'string', array('null' => true, 'limit' => 255))
            ->addColumn('file', 'string', array('null' => true, 'limit' => 50))
            ->addColumn('line', 'integer', array('null' => true, 'limit' => 11))
            ->addColumn('severity', 'enum', array('null' => true, 'default' => 'error', 'values' => array('warning','error','critical','alert','emergency')))
            ->addColumn('occurrence', 'integer', array('null' => true, 'default' => '0', 'limit' => 11))
            ->addColumn('data_json', 'text', array('null' => true, 'limit' => MysqlAdapter::TEXT_LONG))
            ->addColumn('snapshot_json', 'text', array('null' => true, 'limit' => MysqlAdapter::TEXT_LONG))
            ->addIndex(array('type', 'message', 'file', 'line'), array('unique' => true))
            ->create();


    }
}