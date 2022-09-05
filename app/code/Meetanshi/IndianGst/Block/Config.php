<?php
namespace Meetanshi\IndianGst\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Meetanshi\IndianGst\Model\ConfigProvider;

/**
 * Class Config
 * @package Meetanshi\IndianGst\Block
 */
class Config extends Template
{
    /**
     * @var array
     */
    protected $jsLayout;

    /**
     * @var ConfigProvider
     */
    protected $configProvider;
 
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        ConfigProvider $configProvider,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->jsLayout = isset($data['jsLayout']) && is_array($data['jsLayout']) ? $data['jsLayout'] : [];
        $this->configProvider = $configProvider;
    }
 
    /**
     * @return string
     */
    public function getJsLayout()
    {
        return \Zend_Json::encode($this->jsLayout);
    }

    /**
     * @return array
     */
    public function getCustomConfig()
    {
        return $this->configProvider->getConfig();
    }
}
