<?php

namespace Ibnab\KillEavCustomer\Plugin\Controller\Account;



class RestrictCustomerPhone
{

    /**
     * @var Magento\Customer\Model\CustomerFactory
     */
    protected $customerFactory;
    /**
     * @var Session
     */
    protected $session;
    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;
    /**
     * RestrictCustomerEmail constructor.
     * @param UrlFactory $urlFactory
     * @param RedirectFactory $redirectFactory
     * @param ManagerInterface $messageManager
     */
    public function __construct(
      \Magento\Customer\Model\CustomerFactory $customerFactory,
      \Magento\Customer\Model\Session $customerSession,
      \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
    )
    {
        $this->session = $customerSession;
        $this->customerFactory = $customerFactory;
        $this->customerRepository = $customerRepository;

    }

    /**
     * @param \Magento\Customer\Controller\Account\CreatePost $subject
     * @param \Closure $proceed
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function afterExecute(
        \Magento\Customer\Controller\Account\EditPost $subject,
        $result
    )
    {
        /** @var \Magento\Framework\App\RequestInterface $request */
        $telephone = $subject->getRequest()->getParam('telephone');
        /*
        $customer = $this->customerFactory->create();
        $customer->load($this->session->getCustomerId());
        $customer->setTelephone($telephone);
        $customer->save();
         * */
        $customer = $this->customerRepository->getById($this->session->getCustomerId());
        $customer->setCustomAttribute('telephone',$telephone);
        $this->customerRepository->save($customer);
        return $result;
    }
}
