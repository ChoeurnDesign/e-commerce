<x-app-layout>
    <div class="py-8 bg-gray-300 dark:bg-gray-900 min-h-screen"> {{-- Added dark mode background and min-h-screen --}}
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 mb-6">
                    <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">Order Confirmed!</h1> {{-- Added dark:text-gray-100 --}}
                <p class="text-lg text-gray-600 dark:text-gray-400">Thank you for your order. We'll send you a confirmation email shortly.</p> {{-- Added dark:text-gray-400 --}}
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-8"> {{-- Added dark:bg-gray-800 --}}
                <div class="px-6 py-4 bg-gray-300 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-700"> {{-- Added dark:bg-gray-700, dark:border-gray-700 --}}
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Order {{ $order->order_number }}</h2> {{-- Added dark:text-gray-100 --}}
                            <p class="text-sm text-gray-600 dark:text-gray-400">Placed on {{ $order->created_at->format('F j, Y') }} at {{ $order->created_at->format('g:i A') }}</p> {{-- Added dark:text-gray-400 --}}
                        </div>
                        <div class="mt-4 sm:mt-0 flex space-x-4">
                            {{-- Status Badges - Assuming dynamic color classes are configured for dark mode in tailwind.config.js --}}
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $order->status_color }}-100 text-{{ $order->status_color }}-800 dark:bg-{{ $order->status_color }}-700 dark:text-{{ $order->status_color }}-100">
                                {{ ucfirst($order->status) }}
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $order->payment_status_color }}-100 text-{{ $order->payment_status_color }}-800 dark:bg-{{ $order->payment_status_color }}-700 dark:text-{{ $order->payment_status_color }}-100">
                                Payment {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Order Items</h3> {{-- Added dark:text-gray-100 --}}
                        <div class="space-y-4">
                            @foreach($order->orderItems as $item)
                                <div class="flex items-center space-x-4 py-4 border-b border-gray-200 dark:border-gray-700 last:border-b-0"> {{-- Added dark:border-gray-700 --}}
                                    {{-- {{ dd($item->product_image) }} --}}
                                    <img src="{{ asset('img/products/' . $item->product->image) }}"
                                        alt="{{ $item->product_name }}"
                                        class="w-16 h-16 object-cover rounded-lg">
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $item->product_name }}</h4> {{-- Added dark:text-gray-100 --}}
                                        @if($item->product_sku)
                                            <p class="text-sm text-gray-500 dark:text-gray-400">SKU: {{ $item->product_sku }}</p> {{-- Added dark:text-gray-400 --}}
                                        @endif
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Quantity: {{ $item->quantity }}</p> {{-- Added dark:text-gray-400 --}}
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">${{ number_format($item->total, 2) }}</p> {{-- Added dark:text-gray-100 --}}
                                        <p class="text-sm text-gray-500 dark:text-gray-400">${{ number_format($item->price, 2) }} each</p> {{-- Added dark:text-gray-400 --}}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Shipping & Billing</h3> {{-- Added dark:text-gray-100 --}}

                            <div class="space-y-6">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Customer Information</h4> {{-- Added dark:text-gray-300 --}}
                                    <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1"> {{-- Added dark:text-gray-400 --}}
                                        <p>{{ $order->customer_name }}</p>
                                        <p>{{ $order->customer_email }}</p>
                                        @if($order->customer_phone)
                                            <p>{{ $order->customer_phone }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div>
                                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Shipping Address</h4> {{-- Added dark:text-gray-300 --}}
                                    <div class="text-sm text-gray-600 dark:text-gray-400"> {{-- Added dark:text-gray-400 --}}
                                        <p>{{ $order->shipping_address }}</p>
                                        <p>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}</p>
                                        <p>{{ $order->shipping_country }}</p>
                                    </div>
                                </div>

                                <div>
                                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Payment Method</h4> {{-- Added dark:text-gray-300 --}}
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</p> {{-- Added dark:text-gray-400 --}}
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Order Summary</h3> {{-- Added dark:text-gray-100 --}}

                            <div class="space-y-3">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600 dark:text-gray-400">Subtotal</span> {{-- Added dark:text-gray-400 --}}
                                    <span class="font-medium text-gray-900 dark:text-gray-100">${{ number_format($order->subtotal, 2) }}</span> {{-- Added dark:text-gray-100 --}}
                                </div>

                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600 dark:text-gray-400">Tax</span> {{-- Added dark:text-gray-400 --}}
                                    <span class="font-medium text-gray-900 dark:text-gray-100">${{ number_format($order->tax_amount, 2) }}</span> {{-- Added dark:text-gray-100 --}}
                                </div>

                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600 dark:text-gray-400">Shipping</span> {{-- Added dark:text-gray-400 --}}
                                    <span class="font-medium text-green-600 dark:text-green-400">Free</span> {{-- Added dark:text-green-400 --}}
                                </div>

                                <div class="border-t border-gray-200 dark:border-gray-700 pt-3"> {{-- Added dark:border-gray-700 --}}
                                    <div class="flex justify-between text-lg font-bold">
                                        <span class="text-gray-900 dark:text-gray-100">Total</span> {{-- Added dark:text-gray-100 --}}
                                        <span class="text-gray-900 dark:text-gray-100">${{ number_format($order->total_price, 2) }}</span> {{-- Added dark:text-gray-100 --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($order->notes)
                        <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700"> {{-- Added dark:border-gray-700 --}}
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Order Notes</h3> {{-- Added dark:text-gray-100 --}}
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $order->notes }}</p> {{-- Added dark:text-gray-400 --}}
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-blue-50 dark:bg-blue-900 rounded-lg p-6 mb-8"> {{-- Added dark:bg-blue-900 --}}
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"> {{-- Added dark:text-blue-400 --}}
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0h6m-6 0l-2 13h10l-2-13m-6 0v4a2 2 0 002 2h2a2 2 0 002-2V7"></path>
                    </svg>
                    <div>
                        <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100">Estimated Delivery</h3> {{-- Added dark:text-blue-100 --}}
                        <p class="text-blue-700 dark:text-blue-300"> {{-- Added dark:text-blue-300 --}}
                            {{ $order->created_at->addDays(7)->format('F j, Y') }} - {{ $order->created_at->addDays(10)->format('F j, Y') }}
                        </p>
                        <p class="text-sm text-blue-600 dark:text-blue-400 mt-1">We'll send you tracking information once your order ships.</p> {{-- Added dark:text-blue-400 --}}
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('products.index') }}"
                   class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3 px-6 rounded-lg transition duration-300 text-center dark:bg-indigo-700 dark:hover:bg-indigo-600"> {{-- Added dark mode for button --}}
                    Continue Shopping
                </a>
                <a href="{{ route('orders.history') }}"
                   class="bg-gray-300 hover:bg-gray-300 text-gray-700 font-medium py-3 px-6 rounded-lg transition duration-300 text-center dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-200"> {{-- Added dark mode for button --}}
                    View Order History
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
