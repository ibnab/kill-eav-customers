<?php
namespace Ibnab\KillEavCustomer\Setup;

use Magento\Framework\Module\Setup\Migration;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;





class InstallData implements InstallDataInterface
{
    /**
     * Customer setup factory
     *
     * @var \Magento\Customer\Setup\CustomerSetupFactory
     */
    private $customerSetupFactory;
    /**
     * Init
     *
     * @param \Magento\Customer\Setup\CustomerSetupFactory $customerSetupFactory
     */
    public function __construct(\Magento\Customer\Setup\CustomerSetupFactory $customerSetupFactory)
    {
        $this->customerSetupFactory = $customerSetupFactory;
    }
    /**
     * Installs DB schema for a module
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {

        $installer = $setup;
        $installer->startSetup();

        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);
        $entityTypeId = $customerSetup->getEntityTypeId(\Magento\Customer\Model\Customer::ENTITY);
        $customerSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, "telephone");

        
        $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, "telephone",  array(
            "type"     => "varchar",
            "backend"  => "",
            "label"    => "Mobile",
            "input"    => "text",
            "source"   => "",
            "visible"  => true,
            "required" => false,
            "default" => "",
            "frontend" => "",
            "unique"     => false,
            "note"       => ""

        ));

        
        $customer_tel   = $customerSetup->getAttribute(\Magento\Customer\Model\Customer::ENTITY, "telephone");
        $customer_tel = $customerSetup->getEavConfig()->getAttribute(\Magento\Customer\Model\Customer::ENTITY, 'telephone');
        $used_in_forms[]="adminhtml_customer";
        $used_in_forms[]="customer_account_create";
        $used_in_forms[]="customer_account_edit";
        $customer_tel->setData("used_in_forms", $used_in_forms)
            ->setData("is_used_for_customer_segment", true)
            ->setData("is_system", 0)
            ->setData("is_user_defined", 1)
            ->setData("is_visible", 1)
            ->setData("sort_order", 100);
        $customer_tel->save();
   
        
        $installer->endSetup();
    }
}
