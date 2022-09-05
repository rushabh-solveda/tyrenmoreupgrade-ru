<?php
namespace Custom\Js\Block;

use Magento\Framework\View\Element\Template;

class Customjs extends Template {

	protected $request;

	protected $blockFactory;

	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		array $data = [],
		\Magento\Framework\App\Request\Http $request
	) {
		parent::__construct($context, $data);
		$this->request = $request;
	}

}