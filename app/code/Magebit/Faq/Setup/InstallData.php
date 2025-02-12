<?php
/**
 * @copyright Copyright (c) 2025 Magebit (https://magebit.com/)
 * @author    <info@magebit.com>
 * @license   GNU General Public License ("GPL") v3.0
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Magebit\Faq\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context): void
    {
        $setup->startSetup();
        $tableName = $setup->getTable('magebit_faq');
        if ($setup->getConnection()->isTableExists($tableName) == true) {
            $data = [
                [
                    'question' => 'Test Question1.',
                    'answer' => 'Test Answer1.',
                    'status' => 1,
                    'position' => 1,
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'question' => 'Test Question2.',
                    'answer' => 'Test Answer2.',
                    'status' => 1,
                    'position' => 2,
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            ];
            foreach ($data as $item) {
                $setup->getConnection()->insert($tableName, $item);
            }
        }
        $setup->endSetup();
    }
}
