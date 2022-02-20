<?php

use yii\db\Migration;

/**
 * Class m200723_155557_create_table_import
 */
class m200812_155557_create_table_steam_app extends Migration
{
    const TABLE_STEAM_APP = '{{%steam_app}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTableIfExists(self::TABLE_STEAM_APP);

        $this->createTable(self::TABLE_STEAM_APP, [
            'id'              => $this->primaryKey(11)->unsigned(),
            'app_id'          => $this->integer(),
            'name'            => $this->string(),
            'initial_playtime' => $this->integer(),
            'created_at'      => $this->dateTime()->defaultExpression('current_timestamp'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete(self::TABLE_STEAM_APP);
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
