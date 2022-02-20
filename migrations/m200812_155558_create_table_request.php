<?php

use yii\db\Migration;

/**
 * Class m200723_155557_create_table_import
 */
class m200812_155558_create_table_request extends Migration
{
    const TABLE_REQUEST_LOG = '{{%request_log}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTableIfExists(self::TABLE_REQUEST_LOG);

        $this->createTable(self::TABLE_REQUEST_LOG, [
            'id'            => $this->primaryKey(11)->unsigned(),
            'request'       => $this->text(),
            'response'      => $this->json()->defaultValue(null),
            'status'        => $this->string(32),
            'created_at'    => $this->dateTime()->defaultExpression('current_timestamp'),
            'error_message' => $this->text()->defaultValue(null),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete(self::TABLE_REQUEST_LOG);
    }

    /**
     * @param $tableName
     */
    protected function dropTableIfExists($tableName)
    {
        $schema = Yii::$app->db->schema->getTableSchema($tableName);
        if ($schema) {
            $this->dropTable($tableName);
        }
    }

}
