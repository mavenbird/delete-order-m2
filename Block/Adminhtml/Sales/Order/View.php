<?php
/**
 * Mavenbird Technologies Private Limited
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://mavenbird.com/Mavenbird-Module-License.txt
 *
 * =================================================================
 *
 * @category   Mavenbird
 * @package    Mavenbird_DeleteOrder
 * @author     Mavenbird Team
 * @copyright  Copyright (c) 2018-2024 Mavenbird Technologies Private Limited ( http://mavenbird.com )
 * @license    http://mavenbird.com/Mavenbird-Module-License.txt
 */

namespace Mavenbird\DeleteOrder\Block\Adminhtml\Sales\Order;

use Mavenbird\DeleteOrder\Helper\Data as HelperData;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;
use Magento\Sales\Block\Adminhtml\Order\View as OrderView;
use Magento\Sales\Helper\Reorder;
use Magento\Sales\Model\Config;

class View extends OrderView
{
    /**
     * Data
     *
     * @var [type]
     */
    protected $_helperData;

    /**
     * Construct
     *
     * @param Context $context
     * @param Registry $registry
     * @param Config $salesConfig
     * @param Reorder $reorderHelper
     * @param HelperData $helperData
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        Config $salesConfig,
        Reorder $reorderHelper,
        HelperData $helperData,
        array $data = []
    ) {
        $this->_helperData = $helperData;
        parent::__construct($context, $registry, $salesConfig, $reorderHelper, $data);
    }
    
    /**
     * Construct
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        if (!$this->_helperData->isEnabled()) {
            return;
        }
        
        $message = __('Do you want to delete this order?');
        $this->addButton(
            'delete_btn',
            [
                'label' => __($this->_helperData->getOrderButtonLabel()),
                'class' => 'go',
                'onclick'   => 'deleteConfirm(\''.$message.'\', \'' . $this->getDeleteOrderUrl() . '\')'
            ]
        );
    }
    
    /**
     * Delete Order Url
     *
     * @return void
     */
    public function getDeleteOrderUrl()
    {
        return $this->getUrl('deleteorder/deleteorder/deleteorder', ['_current'=>true]);
    }
}
