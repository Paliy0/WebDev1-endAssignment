# PHP Shop - E-Commerce Marketplace

## Description

A e-commerce marketplace where customers can browse and purchase products from various shops. Business users can create shops and manage their product catalog. Admins manage users and shops.

## Functionalities

- **User authentication**: Register, login, logout with role-based access (customer/business/admin)
- **Product browsing**: Search, filter, view product details
- **Shopping cart**: Add/remove items, checkout process
- **Order management**: View order history
- **Shop management**: Business users create/edit shops and products
- **Admin panel**: Manage users and shops
- **Image uploads**: Cloudinary integration for product/shop images

## Installation

1. Clone the repository
2. Navigate to `lib/env.php` and configure (optional):
   - Database credentials (preconfigured)
   - Cloudinary credentials for image uploads (needed for displaying images)

3. Run `docker compose up`
4. Navigate to `http://localhost:8080` and log in with your credentials
5. Import phpshop.sql file
6. Navigate to `http://localhost` you should be able to log in or register

## Credentials

Demo Accounts (all use password: password123)

- Admin: admin@phpshop.com
- Business: seller@phpshop.com
- Customer: customer@phpshop.com

## WCAG Compliance

- Semantic HTML: `<header>`, `<nav>`, `<main>`, `<footer>` structure
- Form labels with `for` attribute linked to inputs
- Alt text on all images using product/shop names
- Keyboard navigation support (Escape to close menus)
- Color contrast: `#2C2922` text on `#F7F5F2` background

## GDPR Compliance

- Password hashing with bcrypt
- Prepared statements prevent data leaks
- Session-based cart (no persistent data)
