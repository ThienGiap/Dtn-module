<?php
/**
 * Landofcoder
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * http://landofcoder.com/license
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category   Landofcoder
 * @package    Lof_ChatSystem
 * @copyright  Copyright (c) 2017 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\ChatSystem\Model;

use Magento\TestFramework\Inspection\Exception;

class Sender
{
    /**
     * @var \Lof\ChatSystem\Helper\Data
     */
    protected $helper;
     /**
     * @var Template\TransportBuilder
     */
    protected $transportBuilder;
    /**
     * @var string|null
     */
    protected $messageSubject = null;

    /**
     * @var string|null
     */
    protected $messageBody = null;
     /**
     * @var string|null
     */
    protected $emailSubject = null;

    /**
     * @var string|null
     */
    protected $emailContent = null;

    public $_storeManager;

    protected $_priceCurrency;

    protected $_transportBuilder;

    protected $config;
      /**
     * @var \Magento\Framework\Translate\Inline\StateInterface
     */
    protected $inlineTranslation;

    protected $messageManager;

    protected $userFactory;

    public function __construct(
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Lof\ChatSystem\Model\TransportBuilder $transportBuilder,
        \Magento\Framework\Mail\Template\TransportBuilder $_transportBuilder,
        \Lof\ChatSystem\Model\Config $config,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Lof\ChatSystem\Helper\Data $helper,
        \Magento\User\Model\UserFactory $userFactory
    ) {
        $this->messageManager = $messageManager;
        $this->config = $config;
        $this->inlineTranslation    = $inlineTranslation;
        $this->_transportBuilder = $_transportBuilder;
        $this->transportBuilder = $transportBuilder;
        $this->helper           = $helper;
        $this->userFactory      = $userFactory;
    }

    public function sendEmailChat($data)
    {       
         try {
            $postObject = new \Magento\Framework\DataObject();
            $postObject->setData($data);
            $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
            $admin_email = $this->helper->getConfig('email_settings/email_admin');
            $default_admin_email = "";
            if(isset($data["user_id"]) && $data["user_id"]){
                $user = $this->userFactory->create()->load((int)$data["user_id"]);
                $default_admin_email = $user->getEmail();
            }
            $transport = $this->_transportBuilder
            ->setTemplateIdentifier($this->helper->getConfig('email_settings/customer_chat_template'))

            ->setTemplateOptions(
                [
                'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
            ])
            ->setTemplateVars(['data' => $postObject])
            ->setFrom($this->helper->getConfig('email_settings/sender_email_identity'))
            ->addTo($admin_email)
            ->setReplyTo($admin_email)
            ->getTransport();
 
            try  {
                $transport->sendMessage();
                $this->inlineTranslation->resume();
            } catch(\Exception $e){
                $error = true;
                $this->messageManager->addError(
                    __('We can\'t process your request right now. Sorry, that\'s all we know.')
                    );
            }
            //Send same email to default assigned admin user email.
            if($default_admin_email){
                $transport = $this->_transportBuilder
                ->setTemplateIdentifier($this->helper->getConfig('email_settings/customer_chat_template'))

                ->setTemplateOptions(
                    [
                    'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                    'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                ])
                ->setTemplateVars(['data' => $postObject])
                ->setFrom($this->helper->getConfig('email_settings/sender_email_identity'))
                ->addTo($default_admin_email)
                ->setReplyTo($default_admin_email)
                ->getTransport();
    
                try  {
                    $transport->sendMessage();
                    $this->inlineTranslation->resume();
                } catch(\Exception $e){
                    $error = true;
                    $this->messageManager->addError(
                        __('We can\'t process your request right now. Sorry, that\'s all we know.')
                        );
                }
            }
        } catch (\Exception $e) {
            $this->inlineTranslation->resume();
            $this->messageManager->addError(
                __('We can\'t process your request right now. Sorry, that\'s all we know.')
                );
            return;
        }
    }

    public function sendAdminChat($data)
    {       
         try {
            $postObject = new \Magento\Framework\DataObject();
            $postObject->setData($data);
            $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
            $customer_email = $data['customer_email'];
            $transport = $this->_transportBuilder
            ->setTemplateIdentifier($this->helper->getConfig('email_settings/admin_reply_template'))

            ->setTemplateOptions(
                [
                 'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
            ])
            ->setTemplateVars(['data' => $postObject])
            ->setFrom($this->helper->getConfig('email_settings/sender_email_identity'))
            ->addTo($customer_email)
            ->setReplyTo($customer_email)
            ->getTransport();
            try  {
                $transport->sendMessage();
                $this->inlineTranslation->resume();
            } catch(\Exception $e){
                $error = true;
                $this->messageManager->addError(
                    __('We can\'t process your request right now. Sorry, that\'s all we know.')
                    );
            }
        } catch (\Exception $e) {
            $this->inlineTranslation->resume();
            $this->messageManager->addError(
                __('We can\'t process your request right now. Sorry, that\'s all we know.')
                );
            return;
        }
    }
   
    /**
     * Get email body
     *
     * @return string
     */
    public function getEmailContent($queue)
    {
        if ($this->emailContent == null) {
            $this->getPreviewEmail($queue);
            return $this->transportBuilder->getMessageContent();
        }
        return $this->emailContent;
    }

    /**
     * Get email subject
     *
     * @return null|string
     */
    public function getEmailSubject($queue)
    {
         
        if ($this->emailSubject == null) {
            $this->getPreviewEmail($queue);
            return $this->transportBuilder->getMessageSubject();
        }
        return $this->emailSubject;
    }

    /**
     * Get email body
     *
     * @return string
     */
    public function getMessageContent($queue)
    {
        if ($this->messageBody == null) {
            $this->getPreview($queue);
            return $this->transportBuilder->getMessageContent();
        }
        return $this->messageBody;
    }

    /**
     * Get email subject
     *
     * @return null|string
     */
    public function getMessageSubject($queue)
    {
         
        if ($this->messageSubject == null) {
            $this->getPreview($queue);
            return $this->transportBuilder->getMessageSubject();
        }
        return $this->messageSubject;
    }
}