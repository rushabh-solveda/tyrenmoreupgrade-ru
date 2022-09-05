<?php
/**
 * Webkul Software.
 *
 * @category   Webkul
 * @package    Webkul_PriceList
 * @author     Webkul
 * @copyright  Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license    https://store.webkul.com/license.html
 */

namespace Webkul\PriceList\Logger;

use Magento\Framework\Logger\Handler\Base;
use Monolog\Logger;

class Handler extends Base
{
    /**
     * Logging level
     * @var int
     */
    protected $loggerType = Logger::INFO;

    /**
     * File name
     * @var string
     */
    protected $fileName = '/var/log/pricelist.log';
}
