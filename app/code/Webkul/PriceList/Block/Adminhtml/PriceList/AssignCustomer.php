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
namespace Webkul\PriceList\Block\Adminhtml\PriceList;

use Webkul\PriceList\Model\ResourceModel\Details\CollectionFactory as DetailsCollection;

class AssignCustomer extends \Magento\Backend\Block\Template
{
    /**
     * Block template
     *
     * @var string
     */
    protected $_template = 'pricelist/assign_customer.phtml';

    /**
     * @var \Webkul\PriceList\Block\Adminhtml\PriceList\Customer
     */
    protected $blockGrid;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @var \Magento\Framework\Json\EncoderInterface
     */
    protected $jsonEncoder;

    /**
     * AssignProducts constructor.
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Json\EncoderInterface $jsonEncoder
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        DetailsCollection $detailsCollection = null,
        array $data = []
    ) {
        $this->_registry = $registry;
        $this->_jsonEncoder = $jsonEncoder;
        $this->_detailsCollection = $detailsCollection ?: \Magento\Framework\App\ObjectManager::getInstance()
            ->get(DetailsCollection::class);
        parent::__construct($context, $data);
    }

    /**
     * Retrieve instance of grid block
     *
     * @return \Magento\Framework\View\Element\BlockInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getBlockGrid()
    {
        if (null === $this->blockGrid) {
            $this->blockGrid = $this->getLayout()->createBlock(
                \Webkul\PriceList\Block\Adminhtml\PriceList\Customer::class,
                'pricelist.customer.grid'
            );
        }
        return $this->blockGrid;
    }

    /**
     * Return HTML of grid block
     *
     * @return string
     */
    public function getGridHtml()
    {
        return $this->getBlockGrid()->toHtml();
    }

    /**
     * Retrieve current pricelist instance
     *
     * @return array|null
     */
    public function getPriceList()
    {
        return $this->_registry->registry('pricelist_pricelist');
    }

    /**
     * @return array
     */
    protected function _getSelectedCustomers()
    {
        $customers = array_keys($this->getSelectedCustomers());
        return $customers;
    }

    public function getSelectedCustomersJson()
    {
        $jsonCustomers = [];
        $customers = array_keys($this->getSelectedCustomers());
        if (!empty($customers)) {
            foreach ($customers as $customer) {
                $jsonCustomers[$customer] = true;
            }
            return $this->_jsonEncoder->encode($jsonCustomers);
        }
        return '{}';
    }

    /**
     * @return array
     */
    public function getSelectedCustomers()
    {
        $allCustomers = $this->getRequest()->getPost('pricelist_customers');
        $customers = [];
        if ($allCustomers === null) {
            $priceList = $this->getPriceList();
            $id = $priceList->getId();
            $collection = $this->_detailsCollection
                ->create()
                ->addFieldToFilter("type", 1)
                ->addFieldToFilter("pricelist_id", $id);
            foreach ($collection as $customer) {
                $customers[$customer->getUserId()] = ['position' => $customer->getUserId()];
            }
        } else {
            foreach ($allCustomers as $customer) {
                $customers[$customer] = ['position' => $customer];
            }
        }
        return $customers;
    }
}
