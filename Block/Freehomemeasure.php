<?php

namespace Binstellar\Freehomemeasure\Block;
use Magento\Framework\Registry;

class Freehomemeasure extends \Magento\Framework\View\Element\Template
{
    /**
     * Construct
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    protected $scopeConfig;
    private $directoryData;
    protected $resultJsonFactory;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Directory\Block\Data $directoryData,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\Webapi\Rest\Request $request,
        array $data = []
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->directoryData = $directoryData;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->request = $request;
        parent::__construct($context, $data);
    }

    /**
     * Get form action URL for POST booking request
     *
     * @return string
     */
    public function getFormAction()
    {
        return $this->_storeManager->getStore()->getBaseUrl() . 'free-home-measure';
    }

    public function getSiteKey()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;

        return $this->scopeConfig->getValue('recaptcha_frontend/type_recaptcha/public_key', $storeScope);
    }


    public function getStates()
    {
        return $this->directoryData->getRegionCollection()->toOptionArray();
    }


    /**
     * {@inheritdoc}
     */
    public function getStatelist()
    {   
        $statelist = array();
        
        $states = $this->getStates();
        foreach ($states as $key) {
            if (!empty($key['value']) || !empty($key['title'])) {
                if (($key['title'] != 'Australian Capital Territory') && ($key['title'] != 'Northern Territory')) {
                    $statelist[] = ['id' => $key['value'],'name' => $key['title']];
                }
            }
        }
        
        return $statelist;
    }

    /**
     * {@inheritdoc}
     */
    public function getInterestedIn()
    {   
        $interestedIn = [
            [
                'value' => '',
                'label' => ''
            ],
            [
                'value' => 'Carpet',
                'label' => 'Carpet'
            ],
            [
                'value' => 'Hard Flooring',
                'label' => 'Hard Flooring'
            ],
            [
                'value' => 'Rugs',
                'label' => 'Rugs'
            ],
            [
                'value' => 'Blinds',
                'label' => 'Blinds'
            ],
            [
                'value' => 'Shutters',
                'label' => 'Shutters'
            ],
            [
                'value' => 'Other',
                'label' => 'Other'
            ],
        ];
        
        return $interestedIn;
    }

    protected function _prepareLayout()
    {
        
        $this->pageConfig->setDescription('A member of our team will visit you in the comfort of your own home with pre-agreed sample products, to help you visualise the samples in the home area where they will be installed. Book a free appointment.');
        $this->pageConfig->getTitle()->set(__('Book a Free Home Measure | Binstellar'));
        
        return parent::_prepareLayout();
    }
    
}