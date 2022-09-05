<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_Bannerslider
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

namespace Mageplaza\BannerSlider\Helper;

use Exception;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Store\Model\StoreManagerInterface;
use Mageplaza\BannerSlider\Model\BannerFactory;
use Mageplaza\BannerSlider\Model\Config\Source\Effect;
use Mageplaza\BannerSlider\Model\ResourceModel\Banner\Collection;
use Mageplaza\BannerSlider\Model\Slider;
use Mageplaza\BannerSlider\Model\SliderFactory;
use Mageplaza\Core\Helper\AbstractData;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Data
 * @package Mageplaza\BannerSlider\Helper
 */
class Data extends AbstractData
{
    const CONFIG_MODULE_PATH = 'mpbannerslider';

    /**
     * @var BannerFactory
     */
    public $bannerFactory;

    /**
     * @var SliderFactory
     */
    public $sliderFactory;

    /**
     * @var DateTime
     */
    protected $date;

    /**
     * @var HttpContext
     */
    protected $httpContext;

    /**
     * Data constructor.
     *
     * @param DateTime $date
     * @param Context $context
     * @param HttpContext $httpContext
     * @param BannerFactory $bannerFactory
     * @param SliderFactory $sliderFactory
     * @param StoreManagerInterface $storeManager
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct(
        DateTime $date,
        Context $context,
        HttpContext $httpContext,
        BannerFactory $bannerFactory,
        SliderFactory $sliderFactory,
        StoreManagerInterface $storeManager,
        ObjectManagerInterface $objectManager
    ) {
        $this->date = $date;
        $this->httpContext = $httpContext;
        $this->bannerFactory = $bannerFactory;
        $this->sliderFactory = $sliderFactory;

        parent::__construct($context, $objectManager, $storeManager);
    }

    /**
     * @param Slider $slider
     *
     * @return false|string
     */
    public function getBannerOptions($slider)
    {
        if ($slider && $slider->getDesign() === '1') { //not use Config
            $config = $slider->getData();
        } else {
            $config = $this->getModuleConfig('mpbannerslider_design');
        }

        $defaultOpt = $this->getDefaultConfig($config);
        $responsiveOpt = $this->getResponsiveConfig($slider);
        $effectOpt = $this->getEffectConfig($slider);

        $sliderOptions = array_merge($defaultOpt, $responsiveOpt, $effectOpt);

        return self::jsonEncode($sliderOptions);
    }

    /**
     * @param array $configs
     *
     * @return array
     */
    public function getDefaultConfig($configs)
    {
        $basicConfig = [];
        $useragent=$_SERVER['HTTP_USER_AGENT'];
$device = '';
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
    {
        $device =  "mobile";
    }else{
        $device =  "desktop";
    }
 
        foreach ($configs as $key => $value) {
            if (in_array(
                $key,
                ['autoWidth', 'autoHeight', 'loop', 'nav', 'dots', 'lazyLoad', 'autoplay', 'autoplayTimeout']
            )) {
            
                /*if($key=="autoplay" && $device=="mobile"){
                    $value = 0;
                }*/
                $basicConfig[$key] = (int)$value;
            }
        }

        return $basicConfig;
    }

    /**
     * @param null $slider
     *
     * @return array
     */
    public function getResponsiveConfig($slider = null)
    {
        $defaultResponsive = $this->getModuleConfig('mpbannerslider_design/responsive');
        $sliderResponsive = $slider->getIsResponsive();

        if ((!$defaultResponsive && !$sliderResponsive) || (!$sliderResponsive && $slider->getDesign())) {
            return ['items' => 1];
        }

        $responsiveItemsValue = $slider->getDesign()
            ? $slider->getResponsiveItems()
            : $this->getModuleConfig('mpbannerslider_design/item_slider');

        try {
            $responsiveItems = $this->unserialize($responsiveItemsValue);
        } catch (Exception $e) {
            $responsiveItems = [];
        }

        $result = [];
        foreach ($responsiveItems as $config) {
            $size = $config['size'] ?: 0;
            $items = $config['items'] ?: 0;
            $result[$size] = ['items' => $items];
        }

        return ['responsive' => $result];
    }

    /**
     * @param $slider
     *
     * @return array
     */
    public function getEffectConfig($slider)
    {
        if (!$slider) {
            return [];
        }

        if ($slider->getEffect() === Effect::SLIDER) {
            return [];
        }

        return ['animateOut' => $slider->getEffect()];
    }

    /**
     * @param null $id
     *
     * @return Collection
     */
    public function getBannerCollection($id = null)
    {
        $collection = $this->bannerFactory->create()->getCollection();

        $collection->join(
            ['banner_slider' => $collection->getTable('mageplaza_bannerslider_banner_slider')],
            'main_table.banner_id=banner_slider.banner_id AND banner_slider.slider_id=' . $id,
            ['position']
        );

        $collection->addOrder('position', 'ASC');

        return $collection;
    }

    /**
     * @return \Mageplaza\BannerSlider\Model\ResourceModel\Slider\Collection
     * @throws NoSuchEntityException
     */
    public function getActiveSliders()
    {
        /** @var \Mageplaza\BannerSlider\Model\ResourceModel\Slider\Collection $collection */
        $collection = $this->sliderFactory->create()
            ->getCollection()
            ->addFieldToFilter('customer_group_ids', [
                'finset' => $this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_GROUP)
            ])
            ->addFieldToFilter('status', 1)
            ->addOrder('priority');

        $collection->getSelect()
            ->where('FIND_IN_SET(0, store_ids) OR FIND_IN_SET(?, store_ids)', $this->storeManager->getStore()->getId())
            ->where('from_date is null OR from_date <= ?', $this->date->date())
            ->where('to_date is null OR to_date >= ?', $this->date->date());

        return $collection;
    }
}
