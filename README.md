# Twaaa tours

Manage operations of a small tour business

- Add tour
- Add destinations
- Confirm bookings
- Issue tickets
- Accept bookings from customer

## Tech stack

Laravel + SQLite (easiest to deploy) + Nuxt + Vue + Tailwind

## Deployment

Nuxt frontend running at https://twaaa.fly.dev
Laravel API running at https://twaa-server.fly.dev

## Install in own machine

```cmd
git clone git@github.com:vinmugambi/solutest.git

cd backend && composer install
php artisan migrate
php artisan test
php artisan db:seed


cd ../frontend && yarn install && npm run dev
```
