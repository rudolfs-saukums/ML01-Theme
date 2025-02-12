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

use Magebit\Faq\Model\ResourceModel\Question\CollectionFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Ui\Component\MassAction\Filter;
use Magebit\Faq\Model\QuestionManagement;
use Magento\Backend\Model\View\Result\RedirectFactory;

class MassEnable extends Action implements HttpPostActionInterface
{
    /**
     * @var CollectionFactory
     */
    protected CollectionFactory $collectionFactory;

    /**
     * @var Filter
     */
    public Filter $filter;

    /**
     * @var QuestionManagement
     */
    protected QuestionManagement $questionManagement;

    /**
     * @var RedirectFactory
     */
    protected RedirectFactory $redirectFactory;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param QuestionManagement $questionManagement
     * @param RedirectFactory $redirectFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        QuestionManagement $questionManagement,
        RedirectFactory $redirectFactory
    ) {
        parent::__construct($context);
        $this->collectionFactory = $collectionFactory;
        $this->filter = $filter;
        $this->questionManagement = $questionManagement;
        $this->redirectFactory = $redirectFactory;
    }

    /**
     * @return Redirect|ResultInterface|ResponseInterface
     * @throws AlreadyExistsException
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function execute(): Redirect|ResultInterface|ResponseInterface
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        foreach ($collection as $question) {
            $this->questionManagement->enableQuestion((int)$question->getId());
        }
        $this->messageManager->addSuccessMessage(__('A total of %count record(s) have been enabled.', ['count' => $collection->getSize()]));

        return $this->redirectFactory->create()->setPath('*/*/');
    }
}
