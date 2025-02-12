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
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magebit\Faq\Model\QuestionRepository;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;


class Delete extends Action implements HttpGetActionInterface
{
    /**
     * @see _isAllowed()
     */
    const string ADMIN_RESOURCE = 'Magebit_Faq::question';

    /**
     * @var QuestionRepository
     */
    private readonly QuestionRepository $questionRepository;

    /**
     * @param Context $context
     * @param QuestionRepository $questionRepository
     */
    public function __construct(
        Context $context,
        QuestionRepository $questionRepository
    )
    {
        parent::__construct($context);
        $this->questionRepository = $questionRepository;
    }

    /**
     * @return Redirect|ResponseInterface|ResultInterface
     * @throws NoSuchEntityException
     * @throws StateException
     */
    public function execute(): Redirect|ResultInterface|ResponseInterface
    {
        $id = (int)$this->getRequest()->getParam('id');
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            $model = $this->questionRepository->get($id);
            $this->questionRepository->deleteById($id);
            $this->messageManager->addSuccessMessage(__('The %question has been deleted.', ['question' => $model->getQuestion()]));

            return $resultRedirect->setPath('*/*/');
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a question to delete.'));

        return $resultRedirect->setPath('*/*/');
    }
}
