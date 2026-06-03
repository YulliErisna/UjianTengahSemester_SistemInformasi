# e-Laboratorium - Complete Setup Guide

## Prerequisites

- Node.js 18+
- PHP 8.2+
- MySQL 8.0+
- Composer

## 1. Backend Setup (Laravel API)

```bash
cd Project_SI/backend
```

### Install Dependencies

```bash
composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate
```

### Database Setup

```
Edit .env:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=labsys_db
DB_USERNAME=root
DB_PASSWORD=

# Install MySQL service if needed:
# Download MySQL Installer from mysql.com
# Or run: mysqld --initialize --console
# Start: net start mysql
```

### Migrate & Seed

```bash
php artisan migrate
php artisan db:seed --class=UserRoleSeeder
# Admin: shahira@example.com / password
# Aslab: yulli@example.com / password
```

### Run Backend

```bash
php artisan serve
```

**Backend: http://127.0.0.1:8000**

## 2. Frontend Setup (React + Vite)

```bash
cd Project_SI/LabSys
```

### Install Dependencies

```bash
npm install
```

### Environment (.env)

```
VITE_API_URL=http://127.0.0.1:8000
```

### Run Frontend

```bash
npm run dev
```

**Frontend: http://localhost:8080** (Vite default)

## 3. Test Features

1. **Register**: http://localhost:8080/signup → Mahasiswa
2. **Login**: http://localhost:8080/login
   - Admin: `shahira@example.com` / `password`
   - Aslab: `yulli@example.com` / `password`
3. **Dashboard**: Auto-redirect after login
4. **Inventory**: /inventory (add/view)
5. **Responsive**: Mobile + Desktop green theme

## 4. Production Build

```
Frontend: npm run build → dist/
Backend: php artisan optimize
```

## Troubleshooting

- **DB Error**: Start MySQL `net start mysql`
- **Port 8000 busy**: `php artisan serve --port=8001` → Update VITE_API_URL
- **CORS**: Backend `config/cors.php` allows `http://localhost:8080`

**🎉 e-Laboratorium Ready!**
