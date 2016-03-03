<?php namespace Yoma\FeedFinder\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();
        if (version_compare($context->getVersion(), '1.0.2', '<')) {


            $table = $installer->getConnection()
                ->newTable($installer->getTable('yoma_feedfinder_tree'))
                ->addColumn(
                    'tree_id',
                    Table::TYPE_SMALLINT,
                    NULL,
                    ['identity' => true, 'nullable' => false, 'primary' => true],
                    'Tree ID'
                )
                ->addColumn('title', Table::TYPE_TEXT, 255, ['nullable' => false], 'Tree Title')
                ->addColumn('content', Table::TYPE_TEXT, '2M', [], 'Tree Content')
                ->addColumn('is_active', Table::TYPE_SMALLINT, NULL, ['nullable' => false, 'default' => '1'], 'Is Tree Active?')
                ->addColumn('creation_time', Table::TYPE_DATETIME, NULL, ['nullable' => false], 'Creation Time')
                ->addColumn('update_time', Table::TYPE_DATETIME, NULL, ['nullable' => false], 'Update Time')
                ->setComment('Feed Finder Tree');

            $installer->getConnection()->createTable($table);
        }

        $installer->endSetup();}

}
