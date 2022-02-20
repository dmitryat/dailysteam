<?php

use yii\db\Migration;

/**
 * Class m200723_155557_create_table_import
 */
class m200812_155559_create_table_daily_stat extends Migration
{
    const TABLE_DAILY_PLAYTIME = '{{%daily_playtime}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTableIfExists(self::TABLE_DAILY_PLAYTIME);

        $this->createTable(self::TABLE_DAILY_PLAYTIME, [
            'id'               => $this->primaryKey(11)->unsigned(),
            'app_id'           => $this->integer(),
            'date'             => $this->date(),
            'minutes'          => $this->integer(),
            'playtime_2weeks'  => $this->integer(),
            'playtime_forever' => $this->integer(),
            'created_at'       => $this->dateTime()->defaultExpression('current_timestamp'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete(self::TABLE_DAILY_PLAYTIME);
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
