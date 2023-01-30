<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Binstellar\Freehomemeasure\Controller\Adminhtml;

abstract class Freehomemeasure extends \Magento\Backend\App\Action
{

    const ADMIN_RESOURCE = 'Binstellar_Freehomemeasure::top_level';
    protected $_coreRegistry;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry
    ) {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    /**
     * Init page
     *
     * @param \Magento\Backend\Model\View\Result\Page $resultPage
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function initPage($resultPage)
    {
        $resultPage->setActiveMenu(self::ADMIN_RESOURCE)
            ->addBreadcrumb(__('Binstellar'), __('Binstellar'))
            ->addBreadcrumb(__('Freehomemeasure'), __('Freehomemeasure'));
        return $resultPage;
    }
}

