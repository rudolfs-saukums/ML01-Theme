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

namespace Magebit\Faq\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\{AbstractDb, Context};

class Question extends AbstractDb
{
    /**
     * @param Context $context
     */
    public function __construct(
        Context $context,
    )
    {
        parent::__construct($context);
    }

    /**
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init('magebit_faq', 'id');
    }
}
