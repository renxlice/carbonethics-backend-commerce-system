# CarbonEthics E-Commerce REST API

A production-ready REST API system built with Laravel 12 + Sanctum, implementing authentication, role-based access control, transactional order processing, and clean API architecture designed for scalability and maintainability.

## Project Overview

This project demonstrates modern Laravel development practices with focus on clean code architecture, comprehensive error handling, and extensive testing coverage. The system implements a complete e-commerce backend with proper security measures and data integrity guarantees.

## Technical Implementation

**Architecture Decisions:**
- SQLite database for simplified deployment and setup
- Role-based middleware for clean authorization separation
- Comprehensive input validation across all endpoints
- Database transactions for order processing integrity
- Standardized JSON response format using API Resources
- Eager loading to prevent N+1 query problems

**Problem-Solving Approach:**
- Token validation issues resolved through proper header handling
- Relationship loading optimized with eager loading strategies
- Role-based access control implemented with custom middleware
- Database transaction handling ensures data consistency

## Version History

### v1.0.0 (2026-02-21)
- Initial release with core functionality
- Authentication system with Sanctum
- Role-based access control (admin/user)
- Product management (CRUD operations)
- Order processing with price snapshots
- Comprehensive test suite (19 tests)
- Postman collection for API testing
- Professional documentation

### Future Enhancements
- Order status management
- Product search and filtering
- API rate limiting
- Order history for customers
- Email notifications

## Features

- **Authentication**: Laravel Sanctum-based token authentication
- **Role-Based Access Control**: Admin and User roles with proper authorization
- **Product Management**: Full CRUD operations with status control
- **Order Processing**: Transactional order creation with price snapshots
- **API Resources**: Consistent JSON response format
- **Comprehensive Testing**: Full feature test coverage
- **Professional Architecture**: Clean, scalable, and maintainable code

## Requirements

- PHP 8.2+
- Composer
- Git
- Laravel 12

## Installation

### Prerequisites
- PHP 8.2+ installed
- Composer installed
- Git installed

### Quick Installation (Recommended)

1. **Clone repository**
   ```bash
   git clone https://github.com/renxlice/carbonethics-backend-commerce-system.git
   cd carbonethics-backend-commerce-system
   ```

2. **Install dependencies**
   ```bash
   composer install --no-dev --optimize-autoloader
   ```

3. **Environment setup**
   ```bash
   cp .env.hrdsample .env
   php artisan key:generate
   ```

4. **Database setup**
   ```bash
   # Database file is created automatically
   php artisan migrate:fresh --seed
   ```

5. **Start development server**
   ```bash
   php artisan serve --host=127.0.0.1 --port=8000
   ```

### One-Command Installation
```bash
git clone https://github.com/renxlice/carbonethics-backend-commerce-system.git && cd carbonethics-backend-commerce-system && composer install --no-dev --optimize-autoloader && cp .env.hrdsample .env && php artisan key:generate && php artisan migrate:fresh --seed && php artisan serve --host=127.0.0.1 --port=8000
```

### Windows PowerShell Installation
```powershell
git clone https://github.com/renxlice/carbonethics-backend-commerce-system.git; cd carbonethics-backend-commerce-system; composer install --no-dev --optimize-autoloader; cp .env.hrdsample .env; php artisan key:generate; php artisan migrate:fresh --seed; php artisan serve --host=127.0.0.1 --port=8000
```

### Troubleshooting

#### Common Issues & Solutions

**Issue**: "Vendor directory not found"
```bash
Solution: composer install --no-dev --optimize-autoloader
```

**Issue**: ".env file not found"
```bash
Solution: cp .env.hrdsample .env && php artisan key:generate
```

**Issue**: "Database connection failed"
```bash
Solution: php artisan migrate:fresh --seed
```

**Issue**: "Port already in use"
```bash
Solution: php artisan serve --port=8001
```

**Issue**: "Permission denied"
```bash
Solution: Check directory permissions for database/ and storage/
```

### Verification
```bash
# Test API is working
curl http://127.0.0.1:8000/api/products
```

## API Documentation

### Authentication Endpoints

#### Login
```http
POST /api/login
Content-Type: application/json

{
  "email": "admin@example.com",
  "password": "password"
}
```

#### Logout
```http
POST /api/logout
Authorization: Bearer {token}
```

### Product Endpoints

#### Get All Products (Public)
```http
GET /api/products
```

#### Get Single Product (Public)
```http
GET /api/products/{id}
```

#### Create Product (Admin Only)
```http
POST /api/products
Authorization: Bearer {admin_token}
Content-Type: application/json

{
  "name": "Product Name",
  "description": "Product description",
  "price": 99.99,
  "status": "active"
}
```

#### Update Product (Admin Only)
```http
PUT /api/products/{id}
Authorization: Bearer {admin_token}
Content-Type: application/json

{
  "name": "Updated Product Name",
  "price": 149.99,
  "status": "inactive"
}
```

#### Delete Product (Admin Only)
```http
DELETE /api/products/{id}
Authorization: Bearer {admin_token}
```

### Order Endpoints

#### Create Order (Public)
```http
POST /api/orders
Content-Type: application/json

{
  "customer_name": "John Doe",
  "customer_email": "john@example.com",
  "items": [
    {
      "product_id": 1,
      "qty": 2
    },
    {
      "product_id": 2,
      "qty": 1
    }
  ]
}
```

#### Get All Orders (Admin Only)
```http
GET /api/orders
Authorization: Bearer {admin_token}
```

#### Get Single Order (Admin Only)
```http
GET /api/orders/{id}
Authorization: Bearer {admin_token}
```

## Testing

Run the complete test suite:

```bash
php artisan test
```

Run specific test files:

```bash
# Authentication tests
php artisan test tests/Feature/Feature/AuthTest.php

# Product tests
php artisan test tests/Feature/Feature/ProductTest.php

# Order tests
php artisan test tests/Feature/Feature/OrderTest.php
```

## Database Schema

### Users Table
- `id` - Primary key
- `name` - User name
- `email` - User email (unique)
- `password` - Hashed password
- `role` - User role (admin|user)
- `created_at`, `updated_at` - Timestamps

### Products Table
- `id` - Primary key
- `name` - Product name
- `description` - Product description (nullable)
- `price` - Product price (decimal)
- `status` - Product status (active|inactive)
- `created_at`, `updated_at` - Timestamps

### Orders Table
- `id` - Primary key
- `customer_name` - Customer name
- `customer_email` - Customer email
- `status` - Order status (pending|paid|cancelled)
- `total_price` - Total order price (decimal)
- `created_at`, `updated_at` - Timestamps

### Order Items Table
- `id` - Primary key
- `order_id` - Foreign key to orders
- `product_id` - Foreign key to products
- `qty` - Quantity ordered
- `price` - Price snapshot at time of order
- `subtotal` - Subtotal (qty × price)
- `created_at`, `updated_at` - Timestamps

## Configuration

### Environment Variables

Key environment variables to configure:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=carbonethics_ecommerce
DB_USERNAME=root
DB_PASSWORD=

# Sanctum configuration
SANCTUM_STATEFUL_DOMAINS=localhost
```

### Role System

The system implements two roles:
- **admin**: Full access to all endpoints including product management and order viewing
- **user**: Limited access, can login and logout

## Response Format

All API responses follow a consistent format:

### Success Response
```json
{
  "data": {
    "id": 1,
    "name": "Product Name",
    "price": 99.99,
    "status": "active"
  }
}
```

### Error Response
```json
{
  "message": "Validation failed",
  "errors": {
    "name": ["The name field is required."],
    "price": ["The price must be at least 0."]
  }
}
```

## Error Handling

The API returns appropriate HTTP status codes:

- `200` - Success
- `201` - Created
- `401` - Unauthorized
- `403` - Forbidden
- `404` - Not Found
- `422` - Validation Error
- `500` - Server Error

## Postman Collection

A complete Postman collection is available in the repository:

1. Import the `postman_collection.json` file into Postman
2. Set up environment variables:
   - `base_url`: Your API base URL (e.g., `http://localhost:8000/api`)
   - `admin_token`: Admin authentication token
   - `user_token`: User authentication token

## Architecture Highlights

### Security Features
- Sanctum token-based authentication
- Role-based authorization middleware
- Input validation and sanitization
- SQL injection prevention via Eloquent ORM
- Price snapshot mechanism for order integrity

### Performance Considerations
- Database transactions for order processing
- Efficient query relationships
- Proper indexing on foreign keys
- Resource-based API responses

### Code Quality
- PSR-12 coding standards
- Comprehensive test coverage
- Clean architecture principles
- Proper separation of concerns

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Support

For questions and support:

- Create an issue in the GitHub repository
- Review the API documentation above
- Check the test files for usage examples

---

Built with Laravel 12 + Sanctum
