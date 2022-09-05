<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_PriceList
 * @author    Webkul
 * @copyright Copyright (c)   Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\PriceList\Controller\Adminhtml\PriceList;

use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Webkul\PriceList\Model\PriceListFactory;
use Webkul\PriceList\Model\AssignedRuleFactory;
use Webkul\PriceList\Model\DetailsFactory;
use Webkul\PriceList\Model\ResourceModel\Rule\CollectionFactory as RuleCollection;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var Filter
     */
    protected $_filter;

    /**
     * @var CollectionFactory
     */
    protected $_collectionFactory;

    public function __construct(
        Context $context,
        PriceListFactory $priceList,
        AssignedRuleFactory $assignedRule,
        DetailsFactory $details
    ) {
        $this->_priceList = $priceList;
        $this->_assignedRule = $assignedRule;
        $this->_details = $details;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $date = date("Y-m-d H:i:s");
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($this->getRequest()->isPost()) {
            try {
                $data = $this->getRequest()->getParams();
                $priceList = $this->_priceList->create();
                //redirect if end date is less than start date
                if ($data['pricelist']['end_date'] < $data['pricelist']['start_date']) {
                    $this->messageManager->addError(__("End date should be greater than or equal to start date"));
                    return $resultRedirect->setPath('*/*/');
                }
                if (array_key_exists("id", $data['pricelist'])) {
                    $id = $data['pricelist']['id'];
                    $priceList->addData($data['pricelist'])->setId($id)->save();
                } else {
                    $data['pricelist']['date'] = $date;
                    $priceList->setData($data['pricelist'])->save();
                }
                $priceListId = $priceList->getId();
                $pricelistRules = trim($this->getRequest()->getParam("pricelist_rules"));
                $pricelistCustomers = trim($this->getRequest()->getParam("pricelist_customers"));
                $customerGroup = $this->getRequest()->getParam("assign_customer_group");

                if (array_key_exists("pricelist_rules", $data)) {
                    $this->removeOldAssignedRules($priceListId);
                    $this->assignRules($pricelistRules, $priceListId);
                }

                if (array_key_exists("pricelist_customers", $data)) {
                    $this->removeOldAssignedCustomers($priceListId);
                    $this->assignCustomers($pricelistCustomers, $priceListId);
                }

                if (array_key_exists("assign_customer_group", $data)) {
                    if (array_key_exists("customer_group", $customerGroup)) {
                        $this->removeOldAssignedGroups($priceListId);
                        $this->assignGroups($customerGroup, $priceListId);
                    }
                }
                $this->messageManager->addSuccess(__("Pricelist saved successfully"));
                $params = ['id' => $priceListId, '_current' => true];
                return $resultRedirect->setPath('*/*/edit', $params);
            } catch (\Exception $e) {
                $this->messageManager->addError(__("Something went wrong"));
            }
        } else {
            $this->messageManager->addError(__("Something went wrong"));
        }
        return $resultRedirect->setPath('*/*/');
    }

    protected function deleteItem($item)
    {
        $item->delete();
    }

    protected function saveItem($model, $data)
    {
        $model->setData($data)->save();
    }

    protected function removeOldAssignedRules($priceListId)
    {
        $collection = $this->_assignedRule
                            ->create()
                            ->getCollection()
                            ->addFieldToFilter("pricelist_id", $priceListId);
        foreach ($collection as $item) {
            $this->deleteItem($item);
        }
    }

    protected function assignRules($pricelistRules, $priceListId)
    {
        if ($pricelistRules != "") {
            $pricelistRules = $this->getFormattedData($pricelistRules);
            foreach ($pricelistRules as $pricelistRule) {
                $ruleData = ["pricelist_id" => $priceListId, "rule_id" => $pricelistRule];
                $this->saveItem($this->_assignedRule->create(), $ruleData);
            }
        }
    }

    protected function removeOldAssignedCustomers($priceListId)
    {
        $collection = $this->_details
                            ->create()
                            ->getCollection()
                            ->addFieldToFilter("type", 1)
                            ->addFieldToFilter("pricelist_id", $priceListId);
        foreach ($collection as $item) {
            $this->deleteItem($item);
        }
    }

    protected function assignCustomers($pricelistCustomers, $priceListId)
    {
        if ($pricelistCustomers != "") {
            $pricelistCustomers = $this->getFormattedData($pricelistCustomers);
            foreach ($pricelistCustomers as $pricelistCustomer) {
                $userData = ["pricelist_id" => $priceListId, "user_id" => $pricelistCustomer, "type" => 1];
                $this->saveItem($this->_details->create(), $userData);
            }
        }
    }

    protected function removeOldAssignedGroups($priceListId)
    {
        $collection = $this->_details
                            ->create()
                            ->getCollection()
                            ->addFieldToFilter("type", 2)
                            ->addFieldToFilter("pricelist_id", $priceListId);
        foreach ($collection as $item) {
            $this->deleteItem($item);
        }
    }

    protected function assignGroups($customerGroup, $priceListId)
    {
        try {
            foreach ($customerGroup['customer_group'] as $group) {
                $userData = ["pricelist_id" => $priceListId, "user_id" => $group, "type" => 2];
                $this->saveItem($this->_details->create(), $userData);
            }
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    protected function getFormattedData($string)
    {
        $string = str_replace("=true&", "+", $string);
        $string = str_replace("=true", "", $string);
        $string = str_replace("0=0&", "", $string);
        if (strpos($string, "+") !== false) {
            $data = explode("+", $string);
        } else {
            $data = [$string];
        }
        return $data;
    }
}
