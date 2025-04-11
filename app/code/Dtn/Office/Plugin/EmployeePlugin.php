<?php
namespace Dtn\Office\Plugin;

use Dtn\Office\Controller\Adminhtml\Employee\Save;
use Magento\Backend\Model\Auth as AuthSession;

class EmployeePlugin
{
    protected $authSession;

    public function __construct(AuthSession $authSession)
    {
        $this->authSession = $authSession;
    }
    public function afterExecute(Save $subject, $result)
    {
//        $this->authSession->logout();

        return $result;
    }
}
