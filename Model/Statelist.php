<?php
namespace Binstellar\Freehomemeasure\Model;
use Binstellar\Freehomemeasure\Api\StatelistInterface;
class Statelist implements StatelistInterface
{

    private $directoryData;
    protected $resultJsonFactory;

    public function __construct(
        \Magento\Directory\Block\Data $directoryData,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\Webapi\Rest\Request $request
    ) {
        $this->directoryData = $directoryData;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->request = $request;
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
                $statelist[] = ['id' => $key['value'],'name' => $key['title']];
            }
            
        }

        return $statelist;
         
        
    }
}