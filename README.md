# Zaiqa Restaurant (Laravel + Bootstrap + MySQL)

Restaurant website with online ordering, table booking and a complete admin panel.

---

## Project chalane ka tareeqa (XAMPP par)

### 1. Zaroori cheezein
- **XAMPP** (PHP 8.2 ya us se naya) — https://www.apachefriends.org
- **Composer** — https://getcomposer.org/download

Check karne ke liye CMD mein likhein:
```
php -v
composer -V
```

### 2. Project folder
Zip ko extract karein, phir CMD/Terminal us folder mein kholein:
```
cd zaiqa-restaurant
```

### 3. Laravel packages install karein (internet chahiye, sirf pehli dafa)
```
composer install
```

### 4. .env file banayein
```
copy .env.example .env        (Windows)
cp .env.example .env          (Mac / Linux)

php artisan key:generate
```

### 5. Database banayein
1. XAMPP Control Panel mein **Apache** aur **MySQL** start karein.
2. Browser mein `http://localhost/phpmyadmin` kholein.
3. **New** par click kar ke database banayein, naam: `zaiqa_restaurant`

> `.env` mein pehle se ye settings hain (XAMPP default):
> `DB_DATABASE=zaiqa_restaurant`, `DB_USERNAME=root`, `DB_PASSWORD=` (khali)

### 6. Tables aur demo data
```
php artisan migrate --seed
```
Is se saari tables ban jayengi aur 7 categories, 24 dishes (images ke saath), sample orders, reservations aur users add ho jayenge.

### 7. Website chalayein
```
php artisan serve
```
Ab browser mein kholein: **http://localhost:8000**

---

## Login details

| Role     | Email             | Password  |
|----------|-------------------|-----------|
| Admin    | admin@zaiqa.com   | admin123  |
| Customer | ali@example.com   | password  |

Admin panel: **http://localhost:8000/admin**

---

## Features

### Frontend (Customer side)
- **Home** — hero section, categories, popular dishes, ordering steps, booking banner
- **Menu** — category filter, search, "Add to cart" (page reload ke baghair)
- **Cart** — quantity +/−, remove, free delivery progress bar (Rs. 2,000 se upar free)
- **Checkout** — delivery details, Cash on Delivery, order number
- **Order tracking** — Pending → Confirmed → Preparing → Out for delivery → Delivered
- **Book a table** — date, time, guests, special request
- **About / Contact** — contact form, map, WhatsApp link
- **Login / Register / My account** — apne orders aur bookings dekhein
- Mobile responsive design

### Backend (Admin panel)
- **Dashboard** — aaj ki sale, pending orders, bookings, 7 din ka sales chart
- **Categories** — add / edit / delete, image upload, show/hide
- **Food items** — add / edit / delete, image upload, price, popular, spicy, available/sold out
- **Orders** — status filter, search, status change, order detail
- **Reservations** — approve / cancel / delete
- **Messages** — contact form ke messages (unread badge)
- **Users** — customers ki list, kitne orders aur kitna kharch

---

## Database tables
`users`, `categories`, `foods`, `orders`, `order_items`, `reservations`, `contacts`
(+ Laravel ki apni tables: `password_reset_tokens`, `sessions`, `cache`, `jobs`)

## Important files
```
app/Http/Controllers/           Frontend controllers (Home, Cart, Checkout, Reservation, Contact, Auth, Account)
app/Http/Controllers/Admin/     Admin panel controllers
app/Http/Middleware/AdminMiddleware.php   Sirf admin ko /admin mein jane deta hai
app/Models/                     Category, Food, Order, OrderItem, Reservation, Contact, User
app/Support/Cart.php            Session cart (delivery fee yahan change karein)
config/restaurant.php           Restaurant ka naam, phone, address, timings — yahan badlein
database/migrations/            Tables
database/seeders/DatabaseSeeder.php   Demo data
resources/views/frontend/       Customer pages
resources/views/admin/          Admin pages
public/css/style.css            Website design
public/css/admin.css            Admin design
public/uploads/                 Food aur category images (admin upload bhi yahin jati hain)
```

## Common masle
- **"could not find driver" / SQLSTATE error** — XAMPP mein MySQL start karein aur check karein ke database `zaiqa_restaurant` bana hua hai.
- **"No application encryption key"** — `php artisan key:generate` chalayein.
- **Data dobara shuru se chahiye** — `php artisan migrate:fresh --seed`
- **Image upload nahi ho rahi** — image 2 MB se choti honi chahiye (jpg, png, webp).

---

### Credits
Bootstrap 5.3 aur Bootstrap Icons (MIT), fonts Manrope, Rozha One, Noto Nastaliq Urdu (SIL Open Font License) project ke andar `public/vendor` mein hain, is liye website bina internet ke bhi theek dikhti hai.
Food photos Foodish dataset (github.com/surhud004/Foodish) se li gayi hain; un ki ownership original photographers ki hai. Sirf study/demo ke liye istemal karein; real business ke liye apni photos lagayein.
