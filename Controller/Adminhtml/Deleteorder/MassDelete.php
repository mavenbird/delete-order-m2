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

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;

use Mavenbird\DeleteOrder\Model\OrderFactory;

class MassDelete extends \Magento\Sales\Controller\Adminhtml\Order\AbstractMassAction
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
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param OrderFactory $modelOrderFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        OrderFactory $modelOrderFactory
    ) {
        parent::__construct($context, $filter);
        $this->collectionFactory = $collectionFactory;
        $this->_modelOrderFactory = $modelOrderFactory;
    }
    
    /**
     * Mass Action
     *
     * @param AbstractCollection $collection
     * @return void
     */
    protected function massAction(AbstractCollection $collection)
    {
        $orderIds = [];

        foreach ($collection->getItems() as $order) {
            $orderIds[] = $order->getId();
        }
         
        if (empty($orderIds)) {
            $this->messageManager->addError(__('There is no order to process'));
            $this->_redirect('sales/order/index');
            return;
        }
        try {
            $count = 0;
            foreach ($orderIds as $orderId) {
                if ($this->_modelOrderFactory->create()->deleteOrder([$orderId])) {
                    $count++;
                }
            }
            $this->messageManager->addSuccess(
                __('%1 order(s) successfully deleted', $count)
            );
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('sales/order/index');
    }
}
