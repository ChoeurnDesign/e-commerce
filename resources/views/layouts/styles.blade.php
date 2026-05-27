<style>
    .wishlist-btn { cursor: pointer; transition: color 0.3s; }
    .wishlist-btn.active { color: #ef4444; }
    .rating-stars { color: #fbbf24; }

    /* Suggestions dropdown: follow app theme */
    .search-suggestions {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;

        background: #ffffff;
        color: #111827; /* gray-900 */
        border: 1px solid #e5e7eb; /* gray-200 */
        border-top: none;
        border-radius: 0 0 8px 8px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        z-index: 50;
    }

    /* When Tailwind dark mode class is present */
    .dark .search-suggestions {
        background: #0f172a;       /* slate-900-ish */
        color: #f3f4f6;            /* gray-100 */
        border-color: #1f2937;     /* gray-800 */
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
</style>