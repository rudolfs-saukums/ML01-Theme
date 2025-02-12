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

use Magebit\Faq\Model\QuestionFactory;
use Magebit\Faq\Model\QuestionRepository;
use Magebit\Faq\Model\ResourceModel\Question;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Exception\LocalizedException;

class Save extends Action
{
    /**
     * @var DataPersistorInterface
     */
    protected DataPersistorInterface $dataPersistor;

    /**
     * @var QuestionRepository
     */
    private QuestionRepository $questionRepository;

    /**
     * @var QuestionFactory
     */
    private QuestionFactory $questionFactory;

    /**
     * @var Validator
     */
    protected Validator $formKeyValidator;

    /**
     * @var Question
     */
    protected Question $question;

    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param QuestionRepository $questionRepository
     * @param QuestionFactory $questionFactory
     * @param Validator $formKeyValidator
     * @param Question $questionModel
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        QuestionRepository  $questionRepository,
        QuestionFactory $questionFactory,
        Validator   $formKeyValidator,
        Question $questionModel
    )
    {
        parent::__construct($context);
        $this->dataPersistor = $dataPersistor;
        $this->questionRepository = $questionRepository;
        $this->questionFactory = $questionFactory;
        $this->formKeyValidator = $formKeyValidator;
        $this->question = $questionModel;
    }

    /**
     * @return ResponseInterface
     */
    public function execute(): ResponseInterface
    {
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            $this->messageManager->addErrorMessage(__('Invalid data.'));

            return $this->_redirect('*/*/');
        }
        try {
            $faq = $this->questionFactory->create();
            if (isset($data['id'])) {
                $faq = $this->questionRepository->get($data['id']);
            }
            $faq->setData($data);
            $this->questionRepository->save($faq);
            $this->messageManager->addSuccessMessage(__('FAQ saved successfully.'));
            return $this->_redirect('*/*/index');
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
        }

        return $this->_redirect('*/*/edit', ['id' => $data['id'] ?? null]);
    }


}
