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

namespace Mavenbird\DeleteOrder\Plugin;

abstract class AbstractDeleteButtonPlugin extends PluginAbstract
{
    /**
     * @var \Magento\Backend\Helper\Data
     */
    protected $data;

    /**
     * @param \Magento\Authorization\Model\Acl\AclRetriever $aclRetriever
     * @param \Magento\Backend\Model\Auth\Session $authSession
     * @param \Magento\Backend\Helper\Data $data
     */
    public function __construct(
        \Magento\Authorization\Model\Acl\AclRetriever $aclRetriever,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\Backend\Helper\Data $data
    ) {
        parent::__construct($aclRetriever, $authSession);
        $this->data = $data;
    }

    /**
     * @param object $subject
     * @param mixed $result
     * @return mixed
     */
    public function afterGetBackUrl($subject, $result)
    {
        if ($this->isAllowedResources() && $subject->getRequest()->getFullActionName() == $this->getViewActionName()) {
            $params = $subject->getRequest()->getParams();
            $message = __('Are you sure you want to do this?');
            $entityId = isset($params[$this->getEntityParamName()]) ? $params[$this->getEntityParamName()] : null;
            if ($entityId) {
                $subject->addButton(
                    'mavenbird-delete',
                    [
                        'label' => __('Delete'),
                        'onclick' => 'confirmSetLocation(\'' . $message . '\',\'' . $this->getDeleteUrl($entityId) . '\')',
                        'class' => 'mavenbird-delete'
                    ],
                    -1
                );
            }
        }

        return $result;
    }

    /**
     * @param int|string $entityId
     * @return string
     */
    protected function getDeleteUrl($entityId)
    {
        return $this->data->getUrl($this->getDeleteRoute(), [$this->getEntityParamName() => $entityId]);
    }

    /**
     * @return string
     */
    abstract protected function getViewActionName();

    /**
     * @return string
     */
    abstract protected function getDeleteRoute();

    /**
     * @return string
     */
    abstract protected function getEntityParamName();
}
