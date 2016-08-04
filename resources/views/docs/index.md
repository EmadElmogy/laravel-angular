# Authentication

> Payload

```json
{
    "username": "kian.fahey",
    "password": "12345"
}
```

> Response

```json
{
    "advisor": {
        "id": 8,
        "name": "Amalia Aufderhar",
        "phone": "158974",
        "username": "kian.fahey",
        "password": "12345",
        "day_off": {
            "name": "Monday",
            "id": 3
        },
        "title": {
            "name": "Shared",
            "id": 3
        },
        "api_token": "1duvRtIoy7wKfrMLgLsM",
        "door": {
            "id": 20,
            "name": "Mosciski Ltd"
        }
    }
}
```

`POST {{url}}/api/v1/auth`

Use this request to authenticate an advisor, the user shall provide his username and password and if correct the following response will be returned.

In case of Failure a `401` response will be returned.

### API Token

In the advisor response you'll receive an `api_token` key, save this key on the device as it'll be used to authorize all future requests.

### Authorization

In all future requests you need to provide the following header:

`Authorization: Bearer {{API_TOKEN_HERE}}`

## Logging Out

> Response

```json
{
    "logged_out": true
}
```

`POST {{url}}/api/v1/logout`

# List Sites

> Response

```json
{
    "sites": [
        {
            "id": 1,
            "name": "Murray and Sons",
            "doors": [
                {
                    "id": 1,
                    "name": "Carroll PLC"
                }
            ]
        }
    ]
}
```

`GET {{url}}/api/v1/sites`

The response will contain an array of sites with their doors.

# List Categories

> Response

```json
{
    "categories": [
        {
            "id": 1,
            "brand": {
                "name": "L'Oreal Paris",
                "id": 1
            },
            "name": "Eyes",
            "sub_categories": [
                {
                    "id": 4,
                    "brand": {
                        "name": "L'Oreal Paris",
                        "id": 2
                    },
                    "name": "Eye Liners"
                }
            ]
        }
    ]
}
```

`GET {{url}}/api/v1/categories`

The response will contain an array of categories with their sub categories.

# List Products

> Response

```json
{
    "products": [
        {
            "id": 1,
            "name": "Eye Liner",
            "image": "http://loreal.dev/uploads/image.png",
            "variations": [
                {
                    "id": 1,
                    "name": "Eye Studio Gel Liner Brown",
                    "barcode": "3600530588046"
                }
            ]
        }
    ]
}
```

`GET {{url}}/api/v1/products`

The response will contain an array of products with their variations, you can filter the results by category using URL parameters:

e.g. `GET {{url}}/api/v1/products?category_id=7364`

# List Wiki

> Response

```json
{
    "categories": [
        {
            "id": 1,
            "type": {
                    "name": "Youtube Video",
                    "id": 1
             },
            "title": "How to add a new product.",
            "link": "https://www.youtube.com/watch?v=708mjaHTwKc"
        },
        {
            "id": 2,
            "type": {
                    "name": "PDF File",
                    "id": 2
             },
            "title": "Adding a new report",
            "link": "https://www.megaupload/file_id/1231248623gd"
        }
    ]
}
```

`GET {{url}}/api/v1/wiki`

# Complains

## List Complains

> Response

```json
{
    "complains": [
        {
            "id": 1,
            "comment": "Sample text...",
            "date": "2016-07-09",
            "door": {
                "id": 1,
                "name": "Carroll PLC"
            },
            "advisor": {
                "id": 3,
                "name": "Melyssa Collins"
            }
        }
    ]
}
```

`GET {{url}}/api/v1/complains`

You can filter using URL query parameters for the following filters:

- `date`
- `door_id`
- `advisor_id`

## Send a new Complain

> Payload

```json
{
    "comment": "This is the complain body.....",
    "type": 1
}
```

> Response

```json
{
    "complain": {
        "comment": "This is the complain body.....",
        "date": "2016-07-25 00:03:06",
        "id": 21,
        "advisor": {
            "id": 8,
            "name": "Amalia Aufderhar"
        },
        "door": {
            "id": 20,
            "name": "Mosciski Ltd"
        }
    }
}
```

`POST {{url}}/api/v1/complains`

### Complain Types are:

- 1: Consumer
- 2: Product
- 3: Maintenance
- 4: Competition
- 5: Others

# Customers

> Response

```json
{
    "customers": [
        {
            "id": 1,
            "name": "John Smith",
            "mobile": "1001976453",
            "area": "Ibiza",
            "email": "john@mail.com"
        }
    ]
}
```

`GET {{url}}/api/v1/customers`

You can filter using URL query parameters for the following filters:

- `mobile`

# Reports

## List Reports

> Response

```json
{
    "reports": [
        {
            "id": 12,
            "date": "2016-07-28 14:53:25",
            "door": {
                "id": 2,
                "name": "Bergstrom, Hills and Johnson"
            },
            "advisor": {
                "id": 20,
                "name": "Retta Carter IV"
            }
        }
    ]
}
```

`GET {{url}}/api/v1/reports`

You can filter using URL query parameters for the following filters:

- `date`
- `door_id`
- `advisor_id`

## Get Report

> Response

```json
{
    "report": {
        "id": 1,
        "date": "2016-07-25 23:27:34",
        "door": {
            "id": 1,
            "name": "Carroll PLC"
        },
        "advisor": {
            "id": 5,
            "name": "Yvonne Leffler"
        },
        "product_variations": [
            {
                "id": 2,
                "name": "O'Conner, Runolfsson and Baumbach",
                "barcode": "60257-0442",
                "product": {
                    "id": 1,
                    "category_id": 4,
                    "name": "D'Amore-Stamm",
                    "image": "image.png"
                },
                "sales": 11
            }
        ]
    }
}
```

`GET {{url}}/api/v1/reports/{report_id}`

## Send a new Report

> Payload

```json
{
    "product_variations": [
        {
            "variation_id": 1,
            "sales": 12345.3
        }
    ],
    "customer_id": null ,
    "new_customer": {
        "name": "John Smith",
        "mobile": 1234,
        "area": "Ibiza",
        "email": "mail@mail.com"
    }
}
```

> Response

```json
{
    "report": {
        "date": "2016-07-25 00:23:42",
        "id": 45,
        "advisor": {
            "id": 8,
            "name": "Amalia Aufderhar"
        },
        "door": {
            "id": 20,
            "name": "Mosciski Ltd"
        },
        "product_variations": [
            {
                "id": 1,
                "name": "Durgan PLC",
                "barcode": "60230-8613",
                "product": {
                    "id": 1,
                    "category_id": 4,
                    "name": "D'Amore-Stamm",
                    "image": "image.png"
                },
                "sales": 12345
            }
        ]
    }
}
```

`POST {{url}}/api/v1/reports`

When sending a sales report you can optionally send customer details, if the customer already exists in the system you can send the `customer_id` field, if not you need to set the `customer_id` field to `null` and set the `new_customer` instead as you can see in the payload.

If both `customer_id` and `new_customer` are null, the report will be submitted without customer details.