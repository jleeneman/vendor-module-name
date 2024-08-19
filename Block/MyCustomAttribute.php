<?php
namespace Vendor\ModuleName\Block;

use Magento\Catalog\Block\Product\View as ProductView;

class MyCustomAttribute extends ProductView
{
    /**
     * @return mixed|null
     */
    public function getMyCustomAttribute(): mixed
    {
        $product = $this->getProduct();
        return $product->getData('my_custom_attribute');
    }
}
