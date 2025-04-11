<?php
/**
 * Landofcoder
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * http://www.landofcoder.com/license-agreement.html
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category   Landofcoder
 * @package    Lof_ChatSystem
 * @copyright  Copyright (c) 2016 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\ChatSystem\Controller\Customer;

use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\Session;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Model\Url as CustomerUrl;
use Magento\Framework\Exception\EmailNotConfirmedException;
use Magento\Framework\Exception\AuthenticationException;
use Magento\Framework\Data\Form\FormKey\Validator;

/**
 * This class contains validating seller login functions
 */
class LoginPost extends \Magento\Customer\Controller\AbstractAccount {
    /** @var AccountManagementInterface */
    protected $customerAccountManagement;
    
    /** @var Validator */
    protected $formKeyValidator;
    
    /**
     *
     * @var Session
     */
    protected $session;

    protected $customerUrl;
    
    /**
     *
     * @param Context $context            
     * @param Session $customerSession            
     * @param AccountManagementInterface $customerAccountManagement            
     * @param CustomerUrl $customerHelperData            
     * @param Validator $formKeyValidator                      
     */
    public function __construct(
    	Context $context, 
    	Session $customerSession, 
    	AccountManagementInterface $customerAccountManagement, 
    	CustomerUrl $customerHelperData, 
    	Validator $formKeyValidator
    ) {
        $this->session = $customerSession;
        $this->customerAccountManagement = $customerAccountManagement;
        $this->customerUrl = $customerHelperData;
        $this->formKeyValidator = $formKeyValidator;
        parent::__construct ( $context );
    }
    
    /**
     * Login post action
     *
     * @return \Magento\Framework\Controller\Result\Redirect @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function execute() {
    
        if ($this->session->isLoggedIn () /*|| ! $this->formKeyValidator->validate($this->getRequest())*/) {
            /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create ();
            $resultRedirect->setPath ( '*/*/' );
            return $resultRedirect;
        }
        $resultRedirect = $this->resultRedirectFactory->create ();
        if ($this->getRequest ()->isPost ()) {
            $login = $this->getRequest ()->getPost ( 'login' );
            if (! empty ( $login ['username'] ) && ! empty ( $login ['password'] )) {
                try {
                    $customer = $this->customerAccountManagement->authenticate ( $login ['username'], $login ['password'] );
                    $this->session->setCustomerDataAsLoggedIn ( $customer );
                    $this->session->regenerateId ();
                    $resultRedirect->setPath ( 'customer/account' );
        			return $resultRedirect;
                } catch ( EmailNotConfirmedException $e ) {
                    $value = $this->customerUrl->getEmailConfirmationUrl ( $login ['username'] );
                    $message = __ ( 'This account is not confirmed.' . ' <a href="%1">Click here</a> to resend confirmation email.', $value );
                    $this->messageManager->addError ( $message );
                    $this->session->setUsername ( $login ['username'] );
                } catch ( AuthenticationException $e ) {
                    $message = __ ( 'Invalid login or password.' );
                    $this->messageManager->addError ( $message );
                    $this->session->setUsername ( $login ['username'] );
                } catch ( \Exception $e ) {
                    $this->messageManager->addError ( __ ( 'Invalid login or password.' ) );
                }
            } else {
                $this->messageManager->addError ( __ ( 'A login and a password are required.' ) );
            }
        }
        
        $resultRedirect->setPath ( 'customer/account/login' );
        return $resultRedirect;
    }
}