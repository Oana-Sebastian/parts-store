# Parts Store

A modern parts management application built with Laravel 12, featuring authentication and a clean, responsive interface.

## Tech Stack

- **Backend**: Laravel 12.x (PHP 8.2+)
- **Frontend**: HTML5, Custom CSS3, Laravel Blade
- **Authentication**: Laravel Breeze
- **Database**: SQLite (default) / MySQL / PostgreSQL

## Features

- 🔐 User authentication (login, registration)
- 📦 Parts inventory management
- 🎨 Clean, responsive UI built with custom CSS and Font Awesome
- ⚡ Fast development with Vite hot module replacement
- 🧪 Testing suite with PHPUnit
- 🚀 Queue support for background jobs

## Requirements

- PHP >= 8.2
- Composer
- Node.js >= 18.x
- npm or yarn

## Installation

### Quick Setup

The fastest way to get started is using the built-in setup script:

```bash
composer setup
```

This will:
- Install PHP dependencies
- Copy `.env.example` to `.env`
- Generate application key
- Run database migrations
- Install Node dependencies
- Build frontend assets

### Manual Setup

If you prefer to set up manually:

1. **Clone the repository**
   ```bash
   git clone https://github.com/Oana-Sebastian/parts-store.git
   cd parts-store
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Set up environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure your database**
   
   Edit `.env` and set your database credentials. By default, SQLite is used:
   ```env
   DB_CONNECTION=sqlite
   ```

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **Install Node dependencies and build assets**
   ```bash
   npm install
   npm run build
   ```

## Development

### Running the Development Server

The easiest way to run the full development environment:

```bash
composer dev
```

This will concurrently start:
- Laravel development server (port 8000)
- Queue worker
- Log viewer (Laravel Pail)
- Vite development server with HMR

### Individual Services

Or run services separately:

```bash
# Start Laravel server
php artisan serve

# Watch and compile assets
npm run dev

# Run queue worker
php artisan queue:work

# Watch logs
php artisan pail
```

Visit `http://localhost:8000` in your browser.

## Testing

Run the test suite:

```bash
composer test
```

Or use PHPUnit directly:

```bash
php artisan test
```

## Code Quality

Format your code with Laravel Pint:

```bash
./vendor/bin/pint
```

## Project Structure

```
parts-store/
├── app/                 # Application code
├── bootstrap/           # Framework bootstrap
├── config/              # Configuration files
├── database/            # Migrations, factories, seeders
├── public/              # Public assets
├── resources/           # Views, raw assets
│   ├── css/            # Stylesheets
│   ├── js/             # JavaScript
│   └── views/          # Blade templates
├── routes/              # Route definitions
├── storage/             # Logs, cache, uploads
└── tests/               # Test files
```

## Laravel Sail (Docker)

For Docker-based development:

```bash
# Start containers
./vendor/bin/sail up

# Run artisan commands
./vendor/bin/sail artisan migrate

# Run tests
./vendor/bin/sail test
```

## Deployment

1. Set up your production environment variables
2. Run migrations:
   ```bash
   php artisan migrate --force
   ```
3. Build production assets:
   ```bash
   npm run build
   ```
4. Optimize the application:
   ```bash
   php artisan optimize
   ```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.
