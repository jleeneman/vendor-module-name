<?php

declare(strict_types=1);

namespace Vendor\ModuleName\Plugin;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Phrase;
use Psr\Log\LoggerInterface;

class ValidateMyCustomAttribute
{
    /**
     * @param LoggerInterface $logger
     */
    public function __construct(
       private readonly LoggerInterface $logger
    ) {}

    /**
     * Before save plugin to validate my_custom_attribute.
     *
     * @param ProductRepositoryInterface $subject
     * @param ProductInterface $product
     * @return array
     */
    public function beforeSave(
        ProductRepositoryInterface $subject,
        ProductInterface $product
    ): array {
        try {
            $customAttribute = $product->getCustomAttribute('my_custom_attribute');

            if ($customAttribute) {
                $myCustomAttributeValue = $customAttribute->getValue();

                // Alphanumeric validation
                if (!ctype_alnum($myCustomAttributeValue)) {
                    throw new LocalizedException(new Phrase('The custom attribute "my_custom_attribute" must be alphanumeric.'));
                }

                $product->setCustomAttribute('my_custom_attribute', $myCustomAttributeValue);
            }
        } catch (\Exception $e) {
            $this->logger->error('An unexpected error occurred in class ValidateMyCustomAttribute: ' . $e->getMessage());
        }

        return [$product];
    }
}
