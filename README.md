## Installation Instructions

Clone the Repository and install dependencies `composer install`

Set up ENV

```
cp .env.example .env
```

Define database connection in .env

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Generate Application Key

```
php artisan key:generate
```

Run migrations and seed DB

```
php artisan migrate --seed
```

Start the local development server

```
php artisan serve
```

## API Documentation

## Base URL

https://yourdomain.com/api/v1

## Endpoints

### List Products

`GET /goods`

Retrieve a list of published products.

### Query Parameters:

`category_id` - (optional): Filter products by category ID.

`stock_id` - (optional): Filter products by stock ID.

`price_min` - (optional): Minimum price to filter products.

`price_max` - (optional): Maximum price to filter products.

`fields` - (optional): Comma-separated list of fields to include in the response (e.g., name,price).

`sort_by` - (optional): Field to sort by. Default is id.

`sort_direction` - (optional): Sorting direction. Possible values are asc or desc. Default is desc.

### Response:

Returns a paginated list of products with the specified filters and sorting applied.

### Get Product Details

`GET /goods/{id}`

Retrieve details of a specific product by ID.

### Path Parameters:

`id`: ID of the product to retrieve.

### Response:

Returns detailed information about the specified product if it is published.





