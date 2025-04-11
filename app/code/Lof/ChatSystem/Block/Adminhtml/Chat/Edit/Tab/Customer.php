<?php
/**
 * Venustheme
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Venustheme.com license that is
 * available through the world-wide-web at this URL:
 * http://www.venustheme.com/license-agreement.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Venustheme
 * @package    Lof_ChatSystem
 * @copyright  Copyright (c) 2018 Venustheme (http://www.venustheme.com/)
 * @license    http://www.venustheme.com/LICENSE-1.0.html
 */

namespace Lof\ChatSystem\Block\Adminhtml\Chat\Edit\Tab;


use Magento\Framework\UrlInterface;

/**
 * @SuppressWarnings(PHPMD.DepthOfInheritance)
 */
class Customer extends \Magento\Backend\Block\Widget\Form\Generic implements
    \Magento\Backend\Block\Widget\Tab\TabInterface
{

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    protected $order;

    protected $orderRepository;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Theme\Model\Layout\Source\Layout $pageLayout
     * @param \Magento\Framework\View\Customer Information\Theme\LabelFactory                $labelFactory
     * @param \Magento\Framework\View\Model\PageLayout\Config\BuilderInterface $pageLayoutBuilder
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        UrlInterface $urlBuilder,
        \Magento\Sales\Model\Order $order,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        array $data = []
    ) {
        $this->orderRepository = $orderRepository;
        $this->order = $order;
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form tab configuration
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setShowGlobalIcon(true);
    }

    /**
     * Initialise form fields
     *
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm()
    {
        /*
         * Checking if user have permissions to save information
         */
        $isElementDisabled = !$this->_isAllowedAction('Lof_ChatSystem::chat_edit');
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(['data' => ['html_id_prefix' => 'chat_']]);

        $model = $this->_coreRegistry->registry('lofchatsystem_chat');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('Customer Information'), 'class' => 'fieldset-wide', 'disabled' => $isElementDisabled]
        );
        $fieldset->addField(
            'session_id',
            'note',
            [
                'name' => 'session_id',
                'label' => __('Chat Key'),
                'title' => __('Chat Key'),
                'text' => $model->getSessionId()
            ]
        );
        $fieldset->addField(
            'customer_name',
            'note',
            [
                'name' => 'customer_name',
                'label' => __('Customer Name'),
                'title' => __('Customer Name'),
                'text' => $model->getCustomerName() ?: __('Guest')
            ]
        );
        $fieldset->addField(
            'customer_email',
            'note',
            [
                'name' => 'customer_email',
                'label' => __('Customer Email'),
                'title' => __('Customer Email'),
                'text' => $model->getCustomerEmail() ? "<a href='" . $this->urlBuilder->getUrl('customer/index/edit',
                        ['id' => $model->getCustomerId()]) . "' target='blank' title='" . __('View Customer') . "'>" . $model->getCustomerEmail() . '</a>' : __('Guest')
            ]
        );
        $fieldset->addField(
            'ip',
            'note',
            [
                'name' => 'ip',
                'label' => __('IP Address'),
                'title' => __('IP Address'),
                'text' => $model->getIp()
            ]
        );

        $order_id = $this->order->getCollection()->addFieldToFilter('customer_id',
            $model->getCustomerId())->getLastItem()->getId();
        if ($order_id) {
            $order = $this->orderRepository->get($order_id);
            $orderIncrementId = $order->getIncrementId();
            $fieldset->addField(
                'last_order',
                'note',
                [
                    'name' => 'last_order',
                    'label' => __('Last Order'),
                    'title' => __('Last Order'),
                    'text' => "<a href='" . $this->urlBuilder->getUrl('sales/order/view/order_id',
                            ['id' => $order_id]) . "' target='blank' title='" . __('View Order') . "'>" . $orderIncrementId . '</a>'
                ]
            );
        }
        $form->setValues($model->getData());

        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Customer Information');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Customer Information');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
