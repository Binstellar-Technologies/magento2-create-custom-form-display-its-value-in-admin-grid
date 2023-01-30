<?php

namespace Binstellar\Freehomemeasure\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{

    /**
     * {@inheritdoc}
     */
    public function upgrade(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;

        $installer->startSetup();
        if (version_compare($context->getVersion(), '1.0.2', '<')) {
            $installer->getConnection()->addColumn(
                $installer->getTable('bookfreemeasure'),
                'message',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    '2M',
                    'comment' => 'Message'
                ]
            );
        }

        if (version_compare($context->getVersion(), '1.0.3', '<')) {
            $installer->getConnection()->addColumn(
                $installer->getTable('bookfreemeasure'),
                'interested_in',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' => 'I\'m interested in...'
                ]
            );
            $installer->getConnection()->addColumn(
                $installer->getTable('bookfreemeasure'),
                'interested_in_other',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' => 'I\'m interested in other value'
                ]
            );
        }

        if (version_compare($context->getVersion(), '1.0.4', '<')) {
            $installer->getConnection()->addColumn(
                $installer->getTable('bookfreemeasure'),
                'store_postcode',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' => 'Store Postcode'
                ]
            );
        }

        if (version_compare($context->getVersion(), "1.0.5", "<")) {
            $installer->getConnection()->addColumn(
                $installer->getTable('bookfreemeasure'),
                'created_at',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    'nullable' => true,
                    'comment' => 'Created At'
                ]
            );
        }
        $installer->endSetup();
    }
}