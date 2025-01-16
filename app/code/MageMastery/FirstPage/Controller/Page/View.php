<?php

declare(strict_types=1);

namespace MageMastery\FirstPage\Controller\Page;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;

class View extends Action
{
    /**
     * @var JsonFactory
     */
    private JsonFactory $resultJsonFactory;

    /**
     * @param JsonFactory $resultJsonFactory
     */
    public function __construct(
        Context $context,  // This is the required first argument
        JsonFactory $resultJsonFactory  // Injecting the JsonFactory as a second argument
    ) {
        parent::__construct($context); // Make sure to call the parent constructor
        $this->resultJsonFactory = $resultJsonFactory;
    }

    /**
     * Execute method to return JSON response
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData(['json_data' => 'come from json']);
    }
}
