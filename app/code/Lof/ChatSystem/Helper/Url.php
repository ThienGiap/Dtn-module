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
 * @package    Lof_All
 * @copyright  Copyright (c) 2016 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\ChatSystem\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Url\EncoderInterface;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\ScopeInterface;
use \Magento\Customer\Model\Session;

class Url extends \Magento\Framework\App\Helper\AbstractHelper
{
     /**
     * Route for customer account login page
     */
    const ROUTE_ACCOUNT_LOGIN = 'lofchatsystem/customer/login';
    
    /**
     * Config name for Redirect Customer to Account Dashboard after Logging in setting
     */
    const XML_PATH_CUSTOMER_STARTUP_REDIRECT_TO_DASHBOARD = 'customer/startup/redirect_dashboard';
    
    /**
     * Query param name for last url visited
     */
    const REFERER_QUERY_PARAM_NAME = 'referer';

       const FLAG_IS_URLS_CHECKED = 'check_url_settings';
    
    protected $_frontendUrl;

    /**
     * @var \Magento\Framework\App\ActionFlag
     */
    protected $_actionFlag;
    /**
     *
     * @var UrlInterface
     */
    protected $urlBuilder;
    
    /**
     *
     * @var RequestInterface
     */
    protected $request;
    
    /**
     *
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;
    
    /**
     *
     * @var Session
     */
    protected $customerSession;
    
    /**
     *
     * @var EncoderInterface
     */
    protected $urlEncoder;
    
    /**
     *
     * @param Session $customerSession            
     * @param ScopeConfigInterface $scopeConfig            
     * @param RequestInterface $request            
     * @param UrlInterface $urlBuilder            
     * @param EncoderInterface $urlEncoder            
     */
    public function __construct(
        Session $customerSession, 
        ScopeConfigInterface $scopeConfig, 
        RequestInterface $request, 
        UrlInterface $urlBuilder, 
        \Magento\Framework\Url $frontendUrl,
        \Magento\Framework\App\ActionFlag $actionFlag,
        EncoderInterface $urlEncoder
    ) {
        $this->_frontendUrl = $frontendUrl;
        $this->_actionFlag = $actionFlag;
        $this->request = $request;
        $this->urlBuilder = $urlBuilder;
        $this->scopeConfig = $scopeConfig;
        $this->customerSession = $customerSession;
        $this->urlEncoder = $urlEncoder;
    }

    public function getFrontendUrl($route = '', $params = [])
    {
        return $this->_frontendUrl->getUrl($route,$params);
    }

    /**
     * Redirect to URL
     * @param string $url
     * @return \Magento\Framework\App\ResponseInterface
     */
    public function _redirectUrl($route = '', $params = []){
        $this->getResponse()->setRedirect($this->getFrontendUrl($route, $params));
        $this->session->setIsUrlNotice($this->_actionFlag->get('', self::FLAG_IS_URLS_CHECKED));
        return $this->getResponse();
    }
   
    /**
     * Retrieve customer login url
     *
     * @return string
     */
    public function getLoginUrl() {
        /**
         * Return login url
         */
        return $this->urlBuilder->getUrl ( static::ROUTE_ACCOUNT_LOGIN, $this->getLoginUrlParams () );
    }
    
    /**
     * Retrieve parameters of customer login url
     *
     * @return array
     */
    public function getLoginUrlParams() {
        $params = [ ];
        $referer = $this->request->getParam ( static::REFERER_QUERY_PARAM_NAME );
        if (! $referer && ! $this->scopeConfig->isSetFlag ( static::XML_PATH_CUSTOMER_STARTUP_REDIRECT_TO_DASHBOARD, ScopeInterface::SCOPE_STORE ) && ! $this->customerSession->getNoReferer ()) {
            $referer = $this->urlBuilder->getUrl ( '*/*/*', [ 
                    '_current' => true,
                    '_use_rewrite' => true 
            ] );
            $referer = $this->urlEncoder->encode ( $referer );
        }
        
        if ($referer) {
            $params = [ 
                    static::REFERER_QUERY_PARAM_NAME => $referer 
            ];
        }
        
        return $params;
    }
    
    /**
     * Retrieve customer login POST URL
     *
     * @return string
     */
    public function getLoginPostUrl() {
        /**
         * Declare params
         */
        $params = [ ];
        /**
         * Assing params
         */
        if ($this->request->getParam ( static::REFERER_QUERY_PARAM_NAME )) {
            $params = [ 
                    static::REFERER_QUERY_PARAM_NAME => $this->request->getParam ( static::REFERER_QUERY_PARAM_NAME ) 
            ];
        }
        /**
         * Return customer login post url
         */
        return $this->urlBuilder->getUrl ( 'customer/account/loginPost', $params );
    }
    
    /**
     * Retrieve customer logout url
     *
     * @return string
     */
    public function getLogoutUrl() {
        /**
         * Return account logout url
         */
        return $this->urlBuilder->getUrl ($this->getFrontendUrl('customer/account/logout'));
    }
    
    /**
     * Retrieve customer dashboard url
     *
     * @return string
     */
    public function getDashboardUrl() {
        /**
         * Return customer dashboard url
         */
        return $this->urlBuilder->getUrl ( 'lofchatsystem/customer/dashboard' );
    }
    
    /**
     * Retrieve customer account page url
     *
     * @return string
     */
    public function getAccountUrl() {
        /**
         * Return customer dashboard url
         */
        return $this->urlBuilder->getUrl ( 'lofchatsystem/customer/dashboard' );
    }
    
    /**
     * Retrieve customer register form url
     *
     * @return string
     */
    public function getRegisterUrl() {
        /**
         * Return customer create url
         */
        return $this->urlBuilder->getUrl ( 'customer/create' );
    }
    
    /**
     * Retrieve customer register form post url
     *
     * @return string
     */
    public function getRegisterPostUrl() {
        /**
         * Return customer create post url
         */
        return $this->urlBuilder->getUrl ( 'customer/createpost' );
    }
    
    /**
     * Retrieve customer account edit form url
     *
     * @return string
     */
    public function getEditUrl() {
        /**
         * Return account edit url
         */
        return $this->urlBuilder->getUrl ( 'customer/account/edit' );
    }
    
    /**
     * Retrieve customer edit POST URL
     *
     * @return string
     */
    public function getEditPostUrl() {
        /**
         * To get edit post url
         */
        return $this->urlBuilder->getUrl ( 'customer/account/editpost' );
    }
    
    /**
     * Retrieve url of forgot password page
     *
     * @return string
     */
    public function getForgotPasswordUrl() {
        /**
         * Get forgot password url
         */
        return $this->urlBuilder->getUrl ( 'customer/account/forgotpassword' );
    }
    
    /**
     * Retrieve confirmation URL for Email
     *
     * @param string $email            
     * @return string
     */
    public function getEmailConfirmationUrl($email = null) {
        /**
         * Get account confirmation notification url
         */
        return $this->urlBuilder->getUrl ( 'customer/account/confirmation', [ 
                'email' => $email 
        ] );
    }

}