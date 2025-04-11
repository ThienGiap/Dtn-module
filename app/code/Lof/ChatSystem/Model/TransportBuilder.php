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
 * @copyright  Copyright (c) 2016 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\ChatSystem\Model;

use Magento\Email\Model\AbstractTemplate;

class TransportBuilder extends \Magento\Framework\Mail\Template\TransportBuilder
{
    /**
     * Template data
     *
     * @var array
     */
    protected $templateData = [];
    /**
     * @var \Zend_Mime_Part|string
     */
    protected $content;
    /**
     * @var string
     */
    protected $messageType = \Magento\Framework\Mail\MessageInterface::TYPE_HTML;
    /**
     * Set template data
     *
     * @param array $data
     * @return $this
     */
    /**
     * @var
     */
    protected $subject;
    /**
     * Set template data
     *
     * @param array $data
     * @return $this
     */
    public function setTemplateData($data)
    {
        $this->templateData = $data;
        return $this;
    }
    /**
     * Set message type
     *
     * @param $messageType
     * @return $this
     */
    public function setMessageType($messageType)
    {
        $this->messageType = $messageType;
        return $this;
    }
    /**
     * @param AbstractTemplate $template
     * @return void
     */
    protected function setTemplateFilter(AbstractTemplate $template)
    {
        if (isset($this->templateData['template_filter'])) {
            $template->setTemplateFilter($this->templateData['template_filter']);
        }
    }
    /**
     * Get message content
     *
     * @return string
     */
    public function getMessageContent()
    {
        return
            $this->content instanceof \Zend_Mime_Part ?
            $this->content->getRawContent() :
            $this->content;
    }
     /**
     * Get message subject
     *
     * @return string
     */
    public function getMessageSubject()
    {
        return $this->subject;
    }
    /**
     * Prepare message
     * 
     * @return $this
     */
    protected function prepareMessage()
    {
        $template = $this->getTemplate()->setData($this->templateData);

        $this->message->setMessageType(
            $this->messageType
        )->setBody(
            $template->getProcessedTemplate($this->templateVars)
        )->setSubject(
            $template->getSubject()
        );
        $this->content = $this->message->getBody();
        $this->subject = $template->getSubject();

        return $this;
    }

}
