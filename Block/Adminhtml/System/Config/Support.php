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

namespace Mavenbird\DeleteOrder\Block\Adminhtml\System\Config;

class Support extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * Render
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return void
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $html = '';
        $html .= '<div style="float: left;">
<a href="https://www.mavenbird.com" target="_blank"><img src="https://www.mavenbird.com/pub/media/logo/stores/1/logo.png" width=220px 
style="float:left; padding-right: 35px; margin-top: 40px; " /></a></div>
<div style="float:left">
<h2><b>Mavenbird DeleteOrder Extension</b></h2>
<p>
<b>Installed Version: v1.1.0</b><br>
Website: <a target="_blank" href="https://www.mavenbird.com">https://www.mavenbird.com</a><br>
Like, share and follow us on 
<a target="_blank" href="https://www.facebook.com/mavenbird">Facebook</a> and
<a target="_blank" href="https://twitter.com/mavenbird">Twitter</a>.<br>
Do you need Extension Support? Please create support ticket from <a href="https://www.mavenbird.com" target="_blank">here</a> or <br> please contact us on <a href="mailto:support@mavenbird.com">support@mavenbird.com</a> for quick reply.

</p>
</div>';
        return $html;
    }
}
