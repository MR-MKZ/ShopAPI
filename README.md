# API Documentation

### Base URL

```
https://api.example.com/api/v1
```

## Common Error Codes

-   **400 Bad Request**: Invalid input data
-   **404 Not Found**: Requested resource does not exist
-   **422 Unprocessable Content**: Sended data has validation problem
-   **500 Internal Server Error**: An unexpected error occurred

## Endpoints

### 1. Get all products

-   **URL**: `/products`
-   **Method**: `GET|HEAD`
-   **Headers**
    - `Content-Type: application/json`
-   **Response**: 
    - **200 OK** 
    ```json
    {
        "success": true,
        "data": {
            "current_page": 1,
            "data": [],
            "first_page_url": "http://127.0.0.1:8000/api/v1/products?page=1",
            "from": null,
            "last_page": 1,
            "last_page_url": "http://127.0.0.1:8000/api/v1/products?page=1",
            "links": [
                {
                    "url": null,
                    "label": "&laquo; Previous",
                    "active": false
                },
                {
                    "url": "http://127.0.0.1:8000/api/v1/products?page=1",
                    "label": "1",
                    "active": true
                },
                {
                    "url": null,
                    "label": "Next &raquo;",
                    "active": false
                }
            ],
            "next_page_url": null,
            "path": "http://127.0.0.1:8000/api/v1/products",
            "per_page": 10,
            "prev_page_url": null,
            "to": null,
            "total": 0
        }
    }
    ```

### 2. Get specific product

-   **URL**: `/products/{product}`
-   **Method**: `GET|HEAD`
-   **Headers**
    - `Content-Type: application/json`
-   **Response**:
    -   **200 OK**
    ```json
    {
        "success": true,
        "data": {
            "id": 1,
            "image": "/storage/images/99c22e75953327bc12cdb29dc61aa1b8ac86a3dc.jpg",
            "description": "Hello this is the description",
            "price": 192000
        }
    }
    ```
    -   **404 Not Found** - if the product is invalid.
    ```json
    {
        "success": false,
        "message": "Product not found"
    }
    ```

### 3. Add new product

-   **URL**: `/products`
-   **Method**: `POST`
-   **Query Parameters**
    - **image**: The image of the product
    - **description**: The description of the product
    - **price**: The price of the product
-   **Headers**
    - `Content-Type: application/json`
-   **Response**:
    -   **200 OK**
    ```json
    {
        "success": true,
        "data": {
            "id": 1,
            "image": "/storage/images/99c22e75953327bc12cdb29dc61aa1b8ac86a3dc.jpg",
            "description": "Hello this is the description",
            "price": 192000
        },
        "message": "New product added successfully"
    }
    ```
    -   **422 Unprocessable Content** - if your data has some validation error.
    ```json
    {
        "message": "The price field must be a number.",
        "errors": {
            "price": [
                "The price field must be a number."
            ]
        }
    }

### 4. Edit product

-   **URL**: `/products/{product}`
-   **Method**: `PUT|PATCH`
-   **Query Parameters**
    - **image**: The image of the product
    - **description**: The description of the product
    - **price**: The price of the product
-   **Headers**
    - `Content-Type: application/json`
-   **Response**:
    -   **200 OK**
    ```json
    {
        "success": true,
        "data": {
            "id": 12,
            "image": "/storage/images/99c22e75953327bc12cdb29dc61aa1b8ac86a3dc.jpg",
            "description": "Hello this is edited description",
            "price": 1200000
        },
        "message": "Product edited successfully"
    }
    ```
    -   **404 Not Found** - if the product is invalid.
    ```json
    {
        "success": false,
        "message": "Product not found"
    }
    ```
    -   **422 Unprocessable Content** - if your data has some validation error.
    ```json
    {
        "message": "The price field must be a number.",
        "errors": {
            "price": [
                "The price field must be a number."
            ]
        }
    }
    ```

### 5. Delete product

-   **URL**: `/products/{product}`
-   **Method**: `DELETE`
-   **Headers**
    - `Content-Type: application/json`
-   **Response**:
    -   **204 No Content** 
    ```json
    {}
    ```
    -   **404 NOT FOUND** - if the product is invalid.
    ```json
    {
        "success": false,
        "message": "Product not found"
    }
    ```

## Versioning

-   Current Version: `v1`


<!-- {
    "success": true,
    "data": {
        "image": "/storage/images/99c22e75953327bc12cdb29dc61aa1b8ac86a3dc.jpg",
        "description": "Hello this is the description",
        "price": "192000",
        "id": 12
    },
    "message": "New product added successfully"
} -->
