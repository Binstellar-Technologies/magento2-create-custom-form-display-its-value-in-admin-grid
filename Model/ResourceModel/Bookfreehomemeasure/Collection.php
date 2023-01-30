<?php 
namespace Binstellar\Freehomemeasure\Model\ResourceModel\Bookfreehomemeasure;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection{
	public function _construct(){
		$this->_init("Binstellar\Freehomemeasure\Model\Bookfreehomemeasure","Binstellar\Freehomemeasure\Model\ResourceModel\Bookfreehomemeasure");
	}
}