<style>
    .wishlist-btn { cursor: pointer; transition: color 0.3s; }
    .wishlist-btn.active { color: #ef4444; }
    .rating-stars { color: #fbbf24; }
    .search-suggestions {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 1px solid #e5e7eb;
        border-top: none;
        border-radius: 0 0 8px 8px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        z-index: 50;
    }
    .currency-symbol { font-weight: bold; }
    .mobile-menu { display: none; }
    .notification { animation: slideIn 0.3s ease-out; text-align: center; }
    @keyframes slideIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @media (max-width: 768px) {
        .mobile-menu { display: block; }
        .desktop-menu { display: none; }
    }
    @media (prefers-color-scheme: dark) {
        .search-suggestions { background: #1a1a1a; color: #f3f4f6; border-color: #2d2d2d; }
    }
</style>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/layouts/styles.blade.php ENDPATH**/ ?>