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
     * @var string
     */
    protected $entityIdParam;

    /**
     * @var string
     */
    protected $successMessageTemplate;

    /**
     * @var string
     */
    protected $errorMessageTemplate;

    /**
     * @var string
     */
    protected $redirectPath;

    /**
     * Execute
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $entityId = (int)$this->getRequest()->getParam($this->entityIdParam);
        $incrementId = $this->getEntityIncrementId($entityId);

        try {
            $this->deleteEntity($entityId);
            $this->messageManager->addSuccessMessage(__($this->successMessageTemplate, $incrementId));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__($this->errorMessageTemplate, $incrementId));
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath($this->redirectPath);
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
     * @param int $entityId
     * @return string
     */
    abstract protected function getEntityIncrementId($entityId);

    /**
     * @param int $entityId
     * @return void
     */
    abstract protected function deleteEntity($entityId);
}
