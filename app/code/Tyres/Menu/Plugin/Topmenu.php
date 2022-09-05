<?php
namespace Tyres\Menu\Plugin;

class Topmenu
{
    protected $storeManager;
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager
    )
    {
        $this->storeManager = $storeManager;
    }

    public function beforeGetHtml(
        \Magento\Theme\Block\Html\Topmenu $subject,
        $outermostClass = '',
        $childrenWrapClass = '',
        $limit = 0
    ) {
        $storeIds = [1,3,4,6,7,8];//replace with the id of your store.
        $currentStoreId = $this->storeManager->getStore()->getId();
        if (in_array($currentStoreId, $storeIds)) {
            $menu = $subject->getMenu();
            $newMenuItems = [];
            $firstLevel = $menu->getChildren(3161);
            foreach ($firstLevel as $menuItem) {
                /** @var \Magento\Framework\Data\Tree\Node $menuItem */
                //check if menu is a category
                if (substr($menuItem->getId(), 0, strlen('category-node-')) == 'category-node-') {
                    //get all child nodes (second level) and save them in an array
                    $subItems = $menuItem->getChildren();
                    foreach ($subItems as $subItem) {
                        $newMenuItems[] = $subItem;
                    }

                } else { //if menu item is not a category, leave it in place
                    $newMenuItems[] = $menuItem;
                }
            }
            //remove all menu items
            foreach ($firstLevel as $childNode) {
                $menu->removeChild($childNode);
            }
            //put new menu items back;
            foreach ($newMenuItems as $newMenuItem) {
                $menu->addChild($newMenuItem);
            }
        }
    }
}
