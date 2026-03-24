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

namespace Mavenbird\DeleteOrder\Controller\Adminhtml\Delete;

use Magento\Sales\Controller\Adminhtml\Order\AbstractMassAction;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

abstract class AbstractMassDelete extends AbstractMassAction
{
    /**
     * @param AbstractCollection $collection
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    protected function massAction(AbstractCollection $collection)
    {
        $params = (array)$this->getRequest()->getParams();
        $selectedCollection = $this->filter->getCollection($this->getMassCollectionFactory()->create());
        $order = null;

        foreach ($selectedCollection as $entity) {
            $entityId = (int)$entity->getId();
            $incrementId = $this->getIncrementIdByEntity($entity, $entityId);

            try {
                $order = $this->deleteEntity($entityId);
                $this->messageManager->addSuccessMessage(__($this->getSuccessMessageTemplate(), $incrementId));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__($this->getErrorMessageTemplate(), $incrementId));
            }
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $orderViewNamespace = $this->getOrderViewNamespace();
        if ($orderViewNamespace && isset($params['namespace']) && $params['namespace'] === $orderViewNamespace && $order) {
            $resultRedirect->setPath('sales/order/view', ['order_id' => $order->getId()]);
        } else {
            $resultRedirect->setPath($this->getDefaultRedirectPath());
        }

        return $resultRedirect;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Mavenbird_DeleteOrder::delete_order');
    }

    /**
     * @return mixed
     */
    abstract protected function getMassCollectionFactory();

    /**
     * @param mixed $entity
     * @param int $entityId
     * @return string
     */
    abstract protected function getIncrementIdByEntity($entity, $entityId);

    /**
     * @param int $entityId
     * @return mixed
     */
    abstract protected function deleteEntity($entityId);

    /**
     * @return string
     */
    abstract protected function getSuccessMessageTemplate();

    /**
     * @return string
     */
    abstract protected function getErrorMessageTemplate();

    /**
     * @return string
     */
    abstract protected function getDefaultRedirectPath();

    /**
     * @return string|null
     */
    protected function getOrderViewNamespace()
    {
        return null;
    }
}
