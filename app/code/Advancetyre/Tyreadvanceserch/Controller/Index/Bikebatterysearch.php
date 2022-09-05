<?php

namespace Advancetyre\Tyreadvanceserch\Controller\Index;


class Bikebatterysearch extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;

    /**
     * @param \Magento\Framework\Controller\Result\JsonFactory
     */
    private $jsonFactory;

    /**
     * @param \Magento\Catalog\Model\CategoryFactory
     */
    private $categoryFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory
    ) {
        $this->jsonFactory = $jsonFactory;
        $this->categoryFactory = $categoryFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        $bikeBatteryId = 4242;
        
	//if (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'staging') === false) {
            $bikeBatteryId = 4152;
        //}
	
        $category = $this->categoryFactory->create()->load($bikeBatteryId);
        $categories = $category->getChildrenCategories();
        $batteries = $this->getSubCategories($categories);

        $data = [
            [
                "entity_id" => $bikeBatteryId,
                "name" => "Bike Battery",
                "path" => "1\/375\/3404\/4035",
                "is_active" => "1",
                "is_anchor" => "1",
                "request_path" => "battery\/bike-battery.html",
                "childes" => $batteries
            ]
        ];

        $result = $this->jsonFactory->create();
        $result->setData($data);
        return $result;
    }

    protected function getSubCategories($categories)
    {
        if (count($categories)) {
            foreach ($categories as $category) {
                $subCategory[] = [
                    'entity_id' => $category->getId(),
                    'name' => $category->getName(),
                    'path' => $category->getPath(),
                    'is_active' => $category->getIsActive(),
                    'is_anchor' => $category->getIsAnchor(),
                    'request_path' => $category->getUrl(),
                    'childes' => $this->getSubCategories($category->getChildrenCategories()),
                ];
            }
            return $subCategory;
        }
        return [];
    }
}
