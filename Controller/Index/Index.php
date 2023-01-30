<?php

namespace Binstellar\Freehomemeasure\Controller\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneFactory;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $_storeInfo;
    protected $_storeManagerInterface;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */    
    protected $scopeConfig;

    protected $timezoneFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Binstellar\Freehomemeasure\Model\BookfreehomemeasureFactory  $bookfreehomemeasure,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        ScopeConfigInterface $scopeConfig,
        TimezoneFactory $timezoneFactory
    )
    {
        $this->storeManager = $storeManager;
        $this->_pageFactory = $pageFactory;
        $this->_bookfreehomemeasure = $bookfreehomemeasure;
        $this->transportBuilder = $transportBuilder;
        $this->scopeConfig = $scopeConfig;
        $this->timezoneFactory = $timezoneFactory;
        return parent::__construct($context);
    }

    /**
     * Booking action
     *
     * @return void
     */
    public function execute()
    {
        // 1. POST request : Get booking data

        $timezoneModel = $this->timezoneFactory->create();
        $data = (array) $this->getRequest()->getPost();
        if (!empty($data)) {
            // Retrieve your form data
            $firstname = $data['firstname'];
            $lastname = $data['lastname'];
            $email = $data['email'];
            $phone = $data['phone'];
            $streetaddress = $data['address'];
            $subrub = $data['suburb'];
            $state = $data['state'];
            $postcode = $data['postcode'];
            $datetime = $timezoneModel->formatDate(null, \IntlDateFormatter::LONG);

            //echo'<pre>'; print_r($storeSelected); die('____!!');

            $model = $this->_bookfreehomemeasure->create();
            $model->addData([
                "firstname" => $firstname,
                "lastname" => $lastname,
                "email" => $email,
                "phone" => $phone,
                "streetaddress" => $streetaddress,
                "subrub" => $subrub,
                "state" => $state,
                "postcode" => $postcode,
                "created_at" => $datetime,
                ]);
            $saveData = $model->save();
            if($saveData){
                // $this->sendEmail($data);
                // $this->CustomerEmail($data);
                $this->messageManager->addSuccessMessage('Thank you for submitting details. Our team will get back to you with more details !');
            }else{
                $this->messageManager->addErrorMessage('Not inserted!');
            }
            

            // $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            // $resultRedirect->setUrl('free-home-measure');
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setRefererOrBaseUrl();
            return $resultRedirect;

        }
        // 2. GET request : Render the booking page 
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }


    private function sendEmail($data)
    {
        $timezoneModel = $this->timezoneFactory->create();
        $current_time = $timezoneModel->formatDate(null, \IntlDateFormatter::SHORT, true);
        $current_time = explode(', ', $current_time);
        $firstname = $data['firstname'].' '.$data['lastname'];
        $email = $data['email'];
        $phone = $data['phone'];
        $sddress = $data['address'];
        $subrub = $data['suburb'];
        $state = $data['state'];
        $postcode = $data['postcode'];
        $currentdate = $timezoneModel->formatDate(null, \IntlDateFormatter::LONG);
        $currenttime = $current_time[1];

        //echo "<pre>"; print_r($storeSelected); die();

         $templateVars = [
            'store' => $this->storeManager->getStore(),
            'lastname' => $data['lastname'],
            'name' => $firstname,
            'email'   => $email,
            'telephone' => $phone,
            'address' => $sddress,
            'subrub' => $subrub,
            'state' => $state,
            'postcode' => $postcode,
            'currentdate'    => $currentdate,
            'currenttime'    => $currenttime
        ];

        if ('Other' == $interested_in) {
            $templateVars['interested_in_other'] = $interested_in_other;
        }
        
        $templateOptions = [
            'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
            'store' => $this->storeManager->getStore()->getId()
        ];

        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;

        $cc_emails = '';
        $bcc_emails = '';
        switch ($data['state']) {
            case "Tasmania":
                $cc_emails = $this->scopeConfig->getValue('sales_enquiry_admin_email_nsw/sales_enquiry_admin_email_nsw/sales_enquiry_admin_email_tas_to', $storeScope);
                $bcc_emails = $this->scopeConfig->getValue('sales_enquiry_admin_email_nsw/sales_enquiry_admin_email_nsw/sales_enquiry_admin_email_tas_bcc', $storeScope);
            break;
            case "New South Wales":
                $cc_emails = $this->scopeConfig->getValue('sales_enquiry_admin_email_nsw/sales_enquiry_admin_email_nsw/sales_enquiry_admin_email_nsw_to', $storeScope);
                $bcc_emails = $this->scopeConfig->getValue('sales_enquiry_admin_email_nsw/sales_enquiry_admin_email_nsw/sales_enquiry_admin_email_nsw_bcc', $storeScope);
            break;
            case "Queensland":
                $cc_emails = $this->scopeConfig->getValue('sales_enquiry_admin_email_nsw/sales_enquiry_admin_email_nsw/sales_enquiry_admin_email_qld_to', $storeScope);
                $bcc_emails = $this->scopeConfig->getValue('sales_enquiry_admin_email_nsw/sales_enquiry_admin_email_nsw/sales_enquiry_admin_email_qld_bcc', $storeScope);
            break;
            case "South Australia":
                $cc_emails = $this->scopeConfig->getValue('sales_enquiry_admin_email_nsw/sales_enquiry_admin_email_nsw/sales_enquiry_admin_email_sa_to', $storeScope);
                $bcc_emails = $this->scopeConfig->getValue('sales_enquiry_admin_email_nsw/sales_enquiry_admin_email_nsw/sales_enquiry_admin_email_sa_bcc', $storeScope);
            break;
            case "Victoria":
                $cc_emails = $this->scopeConfig->getValue('sales_enquiry_admin_email_nsw/sales_enquiry_admin_email_nsw/sales_enquiry_admin_email_vic_to', $storeScope);
                $bcc_emails = $this->scopeConfig->getValue('sales_enquiry_admin_email_nsw/sales_enquiry_admin_email_nsw/sales_enquiry_admin_email_vic_bcc', $storeScope);
            break;
            case "Western Australia":
                $cc_emails = $this->scopeConfig->getValue('sales_enquiry_admin_email_nsw/sales_enquiry_admin_email_nsw/sales_enquiry_admin_email_wa_to', $storeScope);
                $bcc_emails = $this->scopeConfig->getValue('sales_enquiry_admin_email_nsw/sales_enquiry_admin_email_nsw/sales_enquiry_admin_email_wa_bcc', $storeScope);
            break;
            default:
        }

        $final_cc_emails = [];
        $cc_emails = explode(',', $cc_emails);    
        foreach ($cc_emails as $cc_email) {
            $final_cc_emails[] = trim($cc_email);
        }

        $final_bcc_emails = [];
        $bcc_emails = explode(',', $bcc_emails);    
        foreach ($bcc_emails as $bcc_email) {
            $final_bcc_emails[] = trim($bcc_email);
        }

        // //
        // $cc_emails = 'testmscgoriteeps@gmail.com';
        // $final_bccemails = ['arjun.cmarix@gmail.com', 'testmysite24@gmail.com'];

        $email_Template = 'hello_template';  
        $formemail = $this->storeManager->getStore()->getConfig('trans_email/ident_general/email');
        $formname = $this->storeManager->getStore()->getConfig('trans_email/ident_general/name');

        /*$to_email = (count($selected_store) > 1) ? $selected_store[1] : (strtolower($selected_store[0]) . '.store@binstellar.com.au');*/

        // if(!empty($selected_store)){
        //     if($selected_store[1] !== ""){
        //         $to_email = $selected_store[1];
        //     }else{
        //         $to_email = (strtolower($selected_store[0]) . '.store@binstellar.com.au');
        //     }
        // }
        
        $this->transportBuilder
            ->setTemplateIdentifier($email_Template)    
            ->setTemplateOptions($templateOptions)
            ->setTemplateVars($templateVars)
            ->setFrom(['name' => $formname,'email' => $formemail])
            ->setReplyTo($email, $firstname)
            ->addTo($to_email);
            if (!empty($final_cc_emails)) {
                $this->transportBuilder->addCc($final_cc_emails);
            }
            if (!empty($final_bcc_emails)) {
                $this->transportBuilder->addBcc($final_bcc_emails);
            }
            $transport = $this->transportBuilder->getTransport();
        $transport->sendMessage();
    }

    private function CustomerEmail($data, $selected_store)
    {
        $timezoneModel = $this->timezoneFactory->create();
        $current_time = $timezoneModel->formatDate(null, \IntlDateFormatter::SHORT, true);
        $current_time = explode(', ', $current_time);
        $firstname = $data['firstname'].' '.$data['lastname'];
        $email = $data['email'];
        $phone = $data['phone'];
        $sddress = $data['address'];
        $subrub = $data['suburb'];
        $state = $data['state'];
        $postcode = $data['postcode'];
        $currentdate = $timezoneModel->formatDate(null, \IntlDateFormatter::LONG);
        $currenttime = $current_time[1];

        //echo "<pre>"; print_r($storeSelected); die();

        $templateVars = [
            'store' => $this->storeManager->getStore(),
            'lastname' => $data['lastname'],
            'name' => $firstname,
            'email'   => $email,
            'telephone' => $phone,
            'address' => $sddress,
            'subrub' => $subrub,
            'state' => $state,
            'postcode' => $postcode,
            'currentdate'    => $currentdate,
            'currenttime'    => $currenttime
        ];
        if ('Other' == $interested_in) {
            $templateVars['interested_in_other'] = $interested_in_other;
        }

        $templateOptions = [
            'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
            'store' => $this->storeManager->getStore()->getId()
        ];

        $email_Template = 'customer_template';  
        $formemail = $this->storeManager->getStore()->getConfig('trans_email/ident_general/email');
        $formname = $this->storeManager->getStore()->getConfig('trans_email/ident_general/name');

        $transport = $this->transportBuilder
            ->setTemplateIdentifier($email_Template)
            ->setTemplateOptions($templateOptions)
            ->setTemplateVars($templateVars)
            ->setFrom(['name' => $formname,'email' => $formemail])
            ->setReplyTo('info@binstellar.com.au', $formname)
            ->addTo($email)
            ->getTransport();
        $transport->sendMessage();
    }
}