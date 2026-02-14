# 🚀 Future Enhancements for ShopEasy

This document outlines potential improvements and feature additions to further enhance the Online Shopping Management system.

---

## 1. Product Search & Advanced Filters
Currently, users can only filter products by category.
- **Improvement:** Add a search bar to the home page to find products by name or description. Add price range filters and sorting (e.g., Price: Low to High).
- **Apply it in:** 
    - `HomeController.php` (update `index` to handle search queries).
    - `home.blade.php` (add search input in the hero or sidebar).

## 2. Product Reviews & Ratings
Enable social proof by letting users rate products they have purchased.
- **Improvement:** Allow users to leave 1-5 star ratings and a text review. Display average ratings on product cards.
- **Apply it in:** 
    - `ProductReview` Model & migration.
    - `ProductController.php` (add review submission logic).
    - `products.show.blade.php` (add review form and list).

## 3. User Wishlist
Allow users to save products for later without adding them to the cart.
- **Improvement:** Add a "Heart" icon to product cards to save them to a wishlist.
- **Apply it in:** 
    - `Wishlist` Model & Controller.
    - `home.blade.php` and `user.dashboard.blade.php`.

## 4. Invoice Generation (PDF)
Provide customers with a professional receipt.
- **Improvement:** Add a "Download Invoice" button on the Order Details page. Use a package like `barryvdh/laravel-dompdf`.
- **Apply it in:** 
    - `OrderController.php` (added download route).
    - `orders.show.blade.php`.

## 5. Real-Time Notifications
Keep users informed about their orders.
- **Improvement:** Send automated emails when an order is "Completed" or "Processing" using Laravel Mail/Notifications.
- **Apply it in:** 
    - `AdminController.php` (trigger email in `updateOrderStatus`).
    - `OrderController.php` (trigger email in `placeOrder`).

## 6. Discount / Coupon System
Boost sales with promotional codes.
- **Improvement:** Add a coupon input field on the Checkout page that calculates a percentage or fixed discount.
- **Apply it in:** 
    - `Coupon` Model & Management (Admin).
    - `OrderController.php` (update total calculation logic).
    - `checkout.blade.php`.

## 7. Admin Sales Analytics
Give the admin deeper insights into business performance.
- **Improvement:** Add charts (using Chart.js) to the admin dashboard showing "Sales over the last 30 days" or "Top Selling Categories".
- **Apply it in:** 
    - `AdminController.php` (fetch analytics data).
    - `admin.dashboard.blade.php`.
