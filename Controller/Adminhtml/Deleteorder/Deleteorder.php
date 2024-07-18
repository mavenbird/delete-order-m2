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

namespace Mavenbird\DeleteOrder\Controller\Adminhtml\Deleteorder;

use Mavenbird\DeleteOrder\Model\OrderFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ObjectManager;

class Deleteorder extends AbstractDeleteorder
{
    /**
     * Factory for Model Order
     *
     * @var [type]
     */
    protected $_modelOrderFactory;

    /**
     * Construct
     *
     * @param Context $context
     * @param OrderFactory $modelOrderFactory
     */
    public function __construct(
        Context $context,
        OrderFactory $modelOrderFactory
    ) {
        $this->_modelOrderFactory = $modelOrderFactory;
        parent::__construct($context);
    }

    /**
     * Execute
     *
     * @return void
     */
    public function execute()
    {
        $orderId = $this->getRequest()->getParam('order_id');
        if (empty($orderId)) {
            $this->messageManager->addError(__('There is no order to process'));
            $this->_redirect('sales/order/index');
            return;
        }
        try {
            if ($this->_modelOrderFactory->create()->deleteOrder([$orderId])) {

            }
                $this->messageManager->addSuccess(__('Order successfully deleted'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('sales/order/index');
    }
}
