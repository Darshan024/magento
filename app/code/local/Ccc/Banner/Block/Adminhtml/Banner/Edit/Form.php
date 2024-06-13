<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright  Copyright (c) 2006-2018 Magento, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Adminhtml cms block edit form
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Ccc_Banner_Block_Adminhtml_Banner_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    /**
     * Init form
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('banner_id');
        $this->setTitle(Mage::helper('banner')->__('Banner Information'));
    }

    /**
     * Load Wysiwyg on demand and Prepare layout
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        // if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
        $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        // }
    }

    protected function _prepareForm()
    {
        $model = Mage::registry('banner_banner');

        $form = new Varien_Data_Form(
            array('id' => 'edit_form', 'action' => $this->getUrl('*/*/save'), 'method' => 'post', 'enctype'=>'multipart/form-data')
        );

        $form->setHtmlIdPrefix('block_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('banner')->__('General Information'), 'class' => 'fieldset-wide'));

        if ($model->getBannerId()) {
            $fieldset->addField(
                'banner_id',
                'hidden',
                array(
                    'name' => 'banner_id',
                )
            );
        }

        $fieldset->addField(
            'banner_image',
            'image',
            array(
                'name' => 'banner_image',
                'label' => Mage::helper('banner')->__('Banner image'),
                'title' => Mage::helper('banner')->__('Banner image'),
                'required' => true,
                'class' => 'validate-xml-banner_image',
            )
        );

        $fieldset->addField(
            'status',
            'select',
            array(
                'label' => Mage::helper('banner')->__('Status'),
                'title' => Mage::helper('banner')->__('Status'),
                'name' => 'status',
                'required' => true,
                'options' => array(
                    '1' => Mage::helper('banner')->__('Enabled'),
                    '2' => Mage::helper('banner')->__('Disabled'),
                ),
            )
        );
        if (!$model->getId()) {
            $model->setData('status', '1');
        }

        $fieldset->addField(
            'show_on',
            'text',
            array(
                'name' => 'show_on',
                'label' => Mage::helper('banner')->__('Show On'),
                'title' => Mage::helper('banner')->__('Show On'),
                'required' => true,
                // 'config' => Mage::getSingleton('cms/wysiwyg_config')->getConfig()
            )
        );

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

}
