<?php
namespace Binstellar\Freehomemeasure\Model;

use Binstellar\Freehomemeasure\Api\FreehomemeasureInterface;
class Freehomemeasure implements FreehomemeasureInterface
{

    protected $_bookfreehomemeasure;
    public $storeManager;

    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Binstellar\Freehomemeasure\Model\BookfreehomemeasureFactory  $bookfreehomemeasure, 
        \Magento\Framework\Webapi\Rest\Request $request
    ){
        $this->storeManager = $storeManager;
        $this->_bookfreehomemeasure = $bookfreehomemeasure;
        $this->request = $request;
        $this->transportBuilder = $transportBuilder;
    }

     /**
     * {@inheritdoc}
     */
    public function setData($firstname)
    {   
        $data = json_decode($this->request->getContent(), true);
        
        echo "<pre>";
        print_r($data);
        die;

        $firstname = $data['firstname'];
        $lastname = $data['lastname'];
        $email = $data['email'];
        $phone =$data['phone'];
        $streetaddress = $data['address'];
        $subrub =$data['subrub'];
        $state = $data['state'];
        $postcode =$data['store'];
        //$store =$data['nearPostcode'];
        //Customize the code as per your requirement.

        $model = $this->_bookfreehomemeasure->create();
        $model->addData([
            "firstname" => $firstname,
            "lastname" => $lastname,
            "email" => $email,
            "phone" => $phone,
            "streetaddress" => $streetaddress,
            "subrub" => $subrub,
            "state" => $state,
            "postcode" => $postcode
            //"store" => $store
            ]);
        $saveData = $model->save();
        if($saveData){
            $this->sendEmail($data);
            return 'Insert Record Successfully !';
        }else{
            return 'Not inserted !';
        }

    }

     /**
     * @param array $post Post data from contact form
     * @return void
     */

    private function sendEmail($data)
    {
        $firstname = $data['firstname'].$data['lastname'];
        $email = $data['email'];
        $phone = $data['phone'];
        $sddress = $data['address'];
        $subrub = $data['subrub'];
        $state = $data['state'];
        $postcode = $data['store'];

         $templateVars = [
                        'store' => $this->storeManager->getStore(),
                        'name' => $firstname,
                        'email'   => $email,
                        'phone' => $phone,
                        'address' => $sddress,
                        'subrub' => $subrub,
                        'state' => $state,
                        'postcode' => $postcode
                    ];
        $templateOptions = ['area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                'store' => $this->storeManager->getStore()->getId()];

                

        $email_Template = 'hello_template';  
        $formemail = $this->storeManager->getStore()->getConfig('trans_email/ident_general/email');
        $formname = $this->storeManager->getStore()->getConfig('trans_email/ident_general/name');

        $transport = $this->transportBuilder
            ->setTemplateIdentifier($email_Template)
            ->setTemplateOptions($templateOptions)
            ->setTemplateVars($templateVars)
            ->setFrom(['name' => $formname,'email' => $formemail])
            ->addTo($email)
            ->getTransport();
        $transport->sendMessage();
    }
}