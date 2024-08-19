# Vendor_ModuleName

## Overview
The `Vendor_ModuleName` module for Magento 2 adds a custom alphanumeric product attribute called `my_custom_attribute` and displays the attribute on the product page.

## System Requirements
This extension requires atleast PHP 8.1

## Installation in app/code
1. Upload the `Vendor/ModuleName` directory to `app/code/`.
2. Run the following commands to enable and set up the module:
```
bin/magento module:enable Vendor_ModuleName
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento cache:flush
```

## Installation through composer
1. Open the `composer.json` file in your Magento root directory.
2. Add the GitHub repository to the `repositories` section:
```
"repositories": [
  "jleeneman": {
      "type": "git",
      "url": "https://github.com/jleeneman/vendor-module-name.git"
  }
],
```
3. Run the following command to install the module:
```
composer require vendor/modulename:1.0.0
```
4. Run the following commands to enable and set up the module:
```
bin/magento module:enable Vendor_ModuleName
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento cache:flush
```

## API Integration
#### REST API
The custom attribute is accessible through Magento's default product detail REST API.

`http://example.com/rest/<store_code>/V1/products/<sku>`

POST, PUT example on how to pass the value:
```
{
  "product": {
    "custom_attributes": [
      {
        "attribute_code": "my_custom_attribute",
        "value": "NewValue123"
      }
    ]
  }
}
```

#### GraphQL API
You can query the custom attribute using the following GraphQL query:

`http://example.com/graphql`

Get `my_custom_attribute` by GraphQL
```
{
  products(
  filter: { sku: { eq: "YourSku" } }
  ) {
    items {
      my_custom_attribute
    }
  }
}
```
