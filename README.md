<h1 align="center">🛍️ ShopExpress</h1>

<p align="center">
  <strong>A full-featured multi-vendor e-commerce marketplace built with Laravel 12.</strong><br>
  Customers · Sellers · Admins — with escrow wallet, multi-tier commission, returns &amp; refunds, real-time chat, and multi-currency support.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-MariaDB-4479A1?logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Tailwind-3.x-06B6D4?logo=tailwindcss&logoColor=white" alt="Tailwind">
  <img src="https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?logo=alpinedotjs&logoColor=white" alt="Alpine">
</p>

---

## 📖 Overview

**ShopExpress** is a production-oriented multi-vendor marketplace that connects three user roles —
**Customers**, **Sellers (vendors)**, and **Administrators** — on a single platform.

It models the real money flow of marketplaces like **Shopee, Lazada and Amazon**:
customer payments are held by the **platform wallet (escrow)**, commission is deducted using a
**multi-tier engine**, and seller earnings are released **only after the order is completed**.

---

## ✨ Key Features

### 🛒 Customer (Storefront)
- Product discovery: homepage with flash-sale countdown, trending/recommended, top stores, hero banners
- Advanced search &amp; filters (keyword, category, price range, rating, on-sale, sorting)
- Themed landing pages: **New Arrivals · Top Rated · Deals · Flash Sale**
- Cart, Wishlist, coupon/promo codes
- 4 payment methods: **Stripe (card), PayPal, Cash on Delivery, Bank Transfer**
- Stripe 3-D Secure (SCA) support
- Order tracking with visual status timeline (Placed → Confirmed → Shipped → Delivered → Completed)
- **Returns &amp; Refunds**: partial returns, reason codes, photo proof, refund to original payment or store credit
- Product &amp; store reviews, follow sellers, report products/sellers
- **Real-time buyer–seller chat** (typing indicators, read receipts, presence)
- Multi-currency &amp; multi-language

### 🏪 Seller (Vendor) Panel
- Seller registration with admin approval workflow (pending → approved / rejected + email)
- Dashboard KPIs: earnings, active products, orders, average rating
- Product CRUD + image gallery + **bulk CSV/Excel import**
- Order fulfilment (confirm → prepare → complete)
- **Earnings &amp; wallet** (escrow — credited only on completion) + **payout requests**
- Returns inbox (approve → auto-refund + stock restore, or reject)
- Store profile, store reviews, follower count

### 🛠️ Admin Panel
- Dashboard with sales/orders charts &amp; time-range filters
- **Sales Report** with KPIs, revenue chart, top products/sellers, and **CSV / Excel / PDF export**
- Catalog management (products, categories with **per-category commission**, on-sale, banners)
- Order management with validated status state-machine
- **Bank-transfer payment verification** queue
- **Seller approval** + **payout processing** (approve → mark paid → reference)
- **Platform wallet ledger** (every money movement recorded)
- Customers, reviews moderation, user reports, store settings, currencies

---

## 🧠 Core Business Logic

| Engine | Description |
|---|---|
| **Platform Wallet (Escrow)** | Customer payment → platform balance → released to seller on completion. Idempotent, full ledger. |
| **Multi-Tier Commission** | Priority: seller promo (0%) → category rate → seller rate → platform default (10%). Stored historically per order. |
| **Payment-Gateway Fees** | Stripe 2.9% + $0.30, PayPal 3.49% + $0.49 — deducted from platform commission. |
| **Coupon Allocation** | Platform-funded (platform absorbs) vs seller-funded (seller subtotal reduced pro-rata). |
| **Returns &amp; Refunds** | Single DB transaction: platform refund + seller-wallet reversal + stock restore + refund issuance. |
| **Auto-Confirm** | Daily cron completes delivered orders after 7 days and releases earnings (industry standard). |

---

## 🧰 Tech Stack

**Backend:** PHP 8.2+ · Laravel 12 · Laravel Breeze (auth) · Sanctum · Spatie Permission · Socialite (Google OAuth)
**Frontend:** Blade · Alpine.js 3 · Livewire 3 · Tailwind CSS 3 · Vite 6 · SweetAlert2
**Database:** MySQL / MariaDB (Eloquent ORM) · Doctrine DBAL
**Payments:** Stripe PHP SDK · PayPal Checkout SDK
**Real-Time:** Pusher + Laravel Echo (WebSockets)
**Other:** Maatwebsite Excel (import/export) · Intervention Image · Google Translate PHP

---

## 🚀 Getting Started

### Requirements
- PHP 8.2+
- Composer
- MySQL / MariaDB (XAMPP works)
- Node.js + npm

### Installation

```bash
# 1. Install PHP dependencies
composer install

# 2. Install JS dependencies
npm install

# 3. Environment
cp .env.example .env
php artisan key:generate

# 4. Configure your database in .env
#    DB_DATABASE=shopexpress
#    DB_USERNAME=root
#    DB_PASSWORD=

# 5. Run migrations + seed demo data
php artisan migrate:fresh --seed

# 6. Build front-end assets
npm run dev      # or: npm run build

# 7. Start the server
php artisan serve
```

Visit **http://localhost:8000**

---

## 🔑 Demo Accounts

After seeding, log in with (all passwords: **`password`**):

| Role | Email |
|---|---|
| **Admin** | `admin@shop.com` |
| **Seller** | `seller@shop.com` (TechWorld VIP) |
| **Customer** | `customer@shop.com` |

> The seeder also creates additional sellers (approved / pending / rejected) and customers, plus
> ~260 real products fetched live from the [DummyJSON API](https://dummyjson.com), categories with
> commission rates, coupons, reviews, orders in **every status**, returns, and payouts.

---

## ⏰ Scheduled Tasks

```bash
# Auto-confirm delivered orders older than 7 days (releases seller earnings)
php artisan orders:auto-confirm

# Run the Laravel scheduler (production: add to cron / Task Scheduler)
php artisan schedule:work
```

---

## 🗄️ Database

- **31 Eloquent models · 40 migrations · 39 related tables**
- Full schema exports are included in the repo root:
  - `shopexpress_schema.sql` — complete raw schema
  - `shopexpress_drawio.sql` — clean schema for **draw.io** ER-diagram import
    *(draw.io → `+` Insert → Advanced → SQL → paste)*

**Core relationship chain (money flow):**
`users → orders → vendor_orders → wallets → payout_requests`
with `platform_transactions` recording every movement and `refunds` / `return_requests` handling reversals.

---

## 📁 Project Structure (highlights)

```
app/
├── Http/Controllers/
│   ├── Admin/          # admin panel (dashboard, orders, sellers, payouts, sales-report…)
│   ├── Seller/         # seller panel (products, orders, earnings, returns…)
│   ├── Chat/           # real-time messaging
│   └── …               # storefront (products, cart, checkout, returns…)
├── Models/             # 31 Eloquent models
├── Services/
│   ├── Commission/     # CommissionService (multi-tier rate resolution)
│   ├── Refund/         # RefundService (returns + refund money flow)
│   └── Report/         # SalesReportService (admin analytics)
├── Exports/            # Maatwebsite Excel exports
├── Notifications/      # order status, chat, seller application…
└── Console/Commands/   # auto-confirm orders, maintenance
database/
├── migrations/         # 40 versioned migrations
└── seeders/            # Demo* seeders (users, products, orders, returns, payouts…)
resources/views/        # 231 Blade templates (admin / seller / storefront)
```

---

## 🗺️ Roadmap

- [ ] Real shipping cost by zone &amp; method (currently free shipping)
- [ ] Async email queue + shipped/delivered/refund emails
- [ ] Product variants (size / color)
- [ ] Wishlist alerts (price drop / back-in-stock)
- [ ] Loyalty &amp; referral system
- [ ] Mobile app (Flutter)

---

## 📄 License

This project was developed as a final-year capstone. Built on the open-source
[Laravel framework](https://laravel.com) (MIT License).
