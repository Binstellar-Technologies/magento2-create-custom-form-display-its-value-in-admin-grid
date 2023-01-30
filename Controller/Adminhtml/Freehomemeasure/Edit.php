<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Binstellar\Freehomemeasure\Controller\Adminhtml\Freehomemeasure;

use Binstellar\Freehomemeasure\Model\BookfreehomemeasureFactory;

class Edit extends \Binstellar\Freehomemeasure\Controller\Adminhtml\Freehomemeasure
{

    protected $resultPageFactory;
    protected $collectionFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        BookfreehomemeasureFactory $collectionFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('id');
        $model = $this->collectionFactory->create();
        
        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Freehomemeasure Details no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->_coreRegistry->register('bookfreemeasure', $model);
        
        // 3. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('View Freehomemeasure Details') : __('View Freehomemeasure Details'),
            $id ? __('View Freehomemeasure Details') : __('View Freehomemeasure Details')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('View Freehomemeasure Details'));
        $resultPage->getConfig()->getTitle()->prepend($model->getFirstname() ? __('%1 Freehomemeasure Details', $model->getFirstname()) : __('View Freehomemeasure Details'));
        return $resultPage;
    }
}

