<?php 
namespace Binstellar\Freehomemeasure\Model\ResourceModel;
class Bookfreehomemeasure extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb{
 public function _construct(){
 $this->_init("bookfreemeasure","id");
 }
}