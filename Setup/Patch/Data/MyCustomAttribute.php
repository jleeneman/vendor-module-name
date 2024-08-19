<?php
namespace Vendor\ModuleName\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Psr\Log\LoggerInterface;

class MyCustomAttribute implements DataPatchInterface, PatchRevertableInterface
{
    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        protected ModuleDataSetupInterface $moduleDataSetup,
        protected EavSetupFactory $eavSetupFactory,
        protected LoggerInterface $logger
    ) {}

    /**
     * @return void
     */
    public function apply(): void
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        try {
            $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
            $eavSetup->addAttribute(
                Product::ENTITY,
                'my_custom_attribute',
                [
                    'type' => 'varchar',
                    'label' => 'My Custom Attribute',
                    'input' => 'text',
                    'required' => false,
                    'sort_order' => 100,
                    'global' => ScopedAttributeInterface::SCOPE_STORE,
                    'group' => 'General',
                    'frontend_class' => 'validate-alphanum',
                    'visible_on_front' => true,
                    'user_defined' => true,
                    'is_html_allowed_on_front' => true,
                    'visible_in_advanced_search' => false,
                    'used_in_product_listing' => true,
                    'is_used_in_grid' => true,
                    'is_visible_in_grid' => true,
                    'is_filterable_in_grid' => true,
                ]
            );

        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * @return array|string[]
     * No dependency on other patches
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * @return void
     */
    public function revert(): void
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        try {
            $eavSetup->removeAttribute(Product::ENTITY, 'my_custom_attribute');
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }
    }

    /**
     * @return string
     */
    public static function getVersion(): string
    {
        return '1.0.0';
    }

    /**
     * @return array|string[]
     * No aliases
     */
    public function getAliases(): array
    {
        return [];
    }
}
