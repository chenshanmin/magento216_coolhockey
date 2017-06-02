<?php
/**
 * Created by PhpStorm.
 * User: silk
 * Date: 2017/5/5
 * Time: 14:21
 */
namespace Mark\Test1\Block\Adminhtml\Blog\Renderer;
class Image extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{

    public function __construct(
        \Magento\Backend\Block\Context $context,
        array $data = []
    )
    {
        parent::__construct($context, $data);
    }

    public function render(\Magento\Framework\DataObject $row)
    {
        //get any data from tour current Grid Column
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
        $image_url = $storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $data = "<img style='width:20px;height:20px' src=\"".$image_url.$row->getImage()."\" alt=''>";
        // do your stuff

        return $data;

    }
}