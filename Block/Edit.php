<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ibnab\KillEavCustomer\Block;

use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;

/**
 * Customer edit form block
 *
 * @api
 * @SuppressWarnings(PHPMD.DepthOfInheritance)
 */
class Edit extends \Magento\Customer\Block\Form\Edit
{

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    
    /**
     * @var Magento\Customer\Model\CustomerFactory
     */
    protected $customerFactory;
    
    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Newsletter\Model\SubscriberFactory $subscriberFactory
     * @param CustomerRepositoryInterface $customerRepository
     * @param AccountManagementInterface $customerAccountManagement
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Newsletter\Model\SubscriberFactory $subscriberFactory,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        CustomerRepositoryInterface $customerRepository,
        AccountManagementInterface $customerAccountManagement,    
        array $data = []
    ) {
       $this->customerSession = $customerSession;
       $this->customerFactory = $customerFactory;
        parent::__construct($context,$customerSession, $subscriberFactory , $customerRepository , $customerAccountManagement ,$data);
    }
    
    public function getCustomerData()
    {
        $customer = $this->customerFactory->create();
        return $customer->load($this->customerSession->getCustomerId());
    }

}
