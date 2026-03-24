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

use Magento\Backend\App\Action;

abstract class AbstractSingleDelete extends Action
{
    /**
     * Execute
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $entityId = (int)$this->getRequest()->getParam($this->getEntityIdParam());
        $incrementId = $this->getEntityIncrementId($entityId);

        try {
            $this->deleteEntity($entityId);
            $this->messageManager->addSuccessMessage(__($this->getSuccessMessageTemplate(), $incrementId));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__($this->getErrorMessageTemplate(), $incrementId));
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath($this->getRedirectPath());
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
     * @return string
     */
    abstract protected function getEntityIdParam();

    /**
     * @param int $entityId
     * @return string
     */
    abstract protected function getEntityIncrementId($entityId);

    /**
     * @param int $entityId
     * @return void
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
    abstract protected function getRedirectPath();
}
