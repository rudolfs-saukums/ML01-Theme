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

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;

class NewAction extends Action
{
    /**
     * @return Page|ResultInterface|ResponseInterface
     */
    public function execute(): Page|ResultInterface|ResponseInterface
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
