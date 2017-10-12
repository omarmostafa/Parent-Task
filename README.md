# Features

  - API for Persist Order and validate order
  - calculate discount value based on certain conditions

# Framework
 - Lumen Framework

### Installation

Require PHP 7.0 to run

Install Composer

Install the dependencies and devDependencies and start the server.

Clone Project 

```sh
$ cd /path/to/folder
$ composer install
```

### Run Project

```sh
$ php -S localhost:8000 -t public
```


### Run Unit Testing

```sh
$ ./vendor/bin/phpunit
```

# Assumptions
 - Certain Collections is 12 & 7
 - Discount value has positive value if all items in order belongs to certain collections

### Config
 if you need to edit config go to app/config.php to set url ,word , limit or certain collections

### API URL 
/api/v1/orders

### Request Parameters

{"order": {
      "order_id": 51275,
      "email": "test@email.com",
      "total_amount_net": "1890.00",
      "shipping_costs": "29.00",
      "payment_method": "VISA",
      "items": [
        {
          "name": "Item1",
          "qnt": 1,
          "value": 1100,
          "category": "Fashion",
          "subcategory": "Jacket",
          "tags": [
            "porsche",
            "design"
          ],
          "collection_id": 12
        },
        {
          "name": "Item2",
          "qnt": 1,
          "value": 790,
          "category": "Watches",
          "subcategory": "sport",
          "tags": [
            "watch",
            "porsche",
            "electronics"
          ],
          "collection_id": 7
        }
      ]
    }
    } 




