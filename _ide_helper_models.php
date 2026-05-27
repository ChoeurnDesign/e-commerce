<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartItem whereUserId($value)
 * @mixin \Eloquent
 */
	class CartItem extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Category
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @property int $id
 * @property int|null $parent_id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string|null $image
 * @property bool $is_active
 * @property int $sort_order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Category> $children
 * @property-read int|null $children_count
 * @property-read string $image_url
 * @property-read string $image_url_with_parent
 * @property-read Category|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @method static Builder<static>|Category active()
 * @method static \Database\Factories\CategoryFactory factory($count = null, $state = [])
 * @method static Builder<static>|Category newModelQuery()
 * @method static Builder<static>|Category newQuery()
 * @method static Builder<static>|Category query()
 * @method static Builder<static>|Category whereCreatedAt($value)
 * @method static Builder<static>|Category whereDescription($value)
 * @method static Builder<static>|Category whereId($value)
 * @method static Builder<static>|Category whereImage($value)
 * @method static Builder<static>|Category whereIsActive($value)
 * @method static Builder<static>|Category whereName($value)
 * @method static Builder<static>|Category whereParentId($value)
 * @method static Builder<static>|Category whereSlug($value)
 * @method static Builder<static>|Category whereSortOrder($value)
 * @method static Builder<static>|Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\ChatMessage|null $lastMessage
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ChatMessage> $messages
 * @property-read int|null $messages_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ChatParticipant> $participants
 * @property-read int|null $participants_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Chat group()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Chat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Chat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Chat orderedByActivity()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Chat private()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Chat query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Chat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Chat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Chat whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Chat whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Chat extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $chat_id
 * @property int|null $sender_id
 * @property string $body
 * @property string $type
 * @property bool $is_read
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Chat $chat
 * @property-read mixed $file_extension
 * @property-read mixed $human_readable_file_size
 * @property-read \App\Models\User|null $sender
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage whereChatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage whereIsRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage whereSenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage withoutTrashed()
 * @mixin \Eloquent
 */
	class ChatMessage extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $chat_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $last_read_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Chat $chat
 * @property-read mixed $last_read_message
 * @property-read mixed $other_participant
 * @property-read mixed $other_user
 * @property-read mixed $unread_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatParticipant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatParticipant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatParticipant query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatParticipant whereChatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatParticipant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatParticipant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatParticipant whereLastReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatParticipant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatParticipant whereUserId($value)
 * @mixin \Eloquent
 */
	class ChatParticipant extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $code
 * @property string $discount
 * @property string|null $expiry_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereExpiryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Coupon extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string|null $symbol
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereSymbol($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Currency extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer search(?string $term)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Customer extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $code
 * @property numeric $rate
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class ExchangeRate extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $image_path
 * @property string|null $title
 * @property string|null $subtitle
 * @property string|null $button_text
 * @property string|null $button_link
 * @property int $order
 * @property int $enabled
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HomepageBanner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HomepageBanner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HomepageBanner query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HomepageBanner whereButtonLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HomepageBanner whereButtonText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HomepageBanner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HomepageBanner whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HomepageBanner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HomepageBanner whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HomepageBanner whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HomepageBanner whereSubtitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HomepageBanner whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HomepageBanner whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class HomepageBanner extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $path
 * @property string|null $original_filename
 * @property int $user_id
 * @property int|null $product_id
 * @property string|null $alt
 * @property string|null $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product|null $product
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image whereAlt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image whereOriginalFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image whereUserId($value)
 * @mixin \Eloquent
 */
	class Image extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $user_id
 * @property int $seller_id
 * @property int $category_id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string|null $short_description
 * @property numeric $price
 * @property numeric|null $compare_price
 * @property numeric|null $sale_price
 * @property int $on_sale Indicates if the product is on sale
 * @property int $stock_quantity
 * @property int $page_views
 * @property string $sku
 * @property string|null $image
 * @property array<array-key, mixed>|null $gallery
 * @property string|null $images
 * @property array<array-key, mixed>|null $specifications
 * @property bool $is_featured
 * @property bool $is_active
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Review> $approvedReviews
 * @property-read int|null $approved_reviews_count
 * @property-read \App\Models\Category $category
 * @property-read \App\Models\User|null $creator
 * @property-read mixed $average_rating
 * @property-read mixed $current_price
 * @property-read int|null $discount_percent
 * @property-read mixed $discount_percentage
 * @property-read mixed $gallery_urls
 * @property-read mixed $has_image
 * @property-read mixed $image_url
 * @property-read mixed $images_urls
 * @property-read mixed $in_stock
 * @property-read mixed $is_on_sale
 * @property-read int|null $reviews_count
 * @property-read mixed $savings
 * @property-read mixed $stock_status
 * @property-read mixed $stock_status_color
 * @property-read mixed $thumbnail_url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderItem> $orderItems
 * @property-read int|null $order_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Review> $reviews
 * @property-read \App\Models\Seller $seller
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Wishlist> $wishlistItems
 * @property-read int|null $wishlist_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $wishlistedByUsers
 * @property-read int|null $wishlisted_by_users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Onsale active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Onsale featured()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Onsale inStock()
 * @method static Builder<static>|Onsale newModelQuery()
 * @method static Builder<static>|Onsale newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Onsale onSale()
 * @method static Builder<static>|Onsale query()
 * @method static Builder<static>|Onsale salePriceBetween(?float $min = null, ?float $max = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Onsale search($term)
 * @method static Builder<static>|Onsale whereCategoryId($value)
 * @method static Builder<static>|Onsale whereComparePrice($value)
 * @method static Builder<static>|Onsale whereCreatedAt($value)
 * @method static Builder<static>|Onsale whereDescription($value)
 * @method static Builder<static>|Onsale whereGallery($value)
 * @method static Builder<static>|Onsale whereId($value)
 * @method static Builder<static>|Onsale whereImage($value)
 * @method static Builder<static>|Onsale whereImages($value)
 * @method static Builder<static>|Onsale whereIsActive($value)
 * @method static Builder<static>|Onsale whereIsFeatured($value)
 * @method static Builder<static>|Onsale whereMetaDescription($value)
 * @method static Builder<static>|Onsale whereMetaTitle($value)
 * @method static Builder<static>|Onsale whereName($value)
 * @method static Builder<static>|Onsale whereOnSale($value)
 * @method static Builder<static>|Onsale wherePageViews($value)
 * @method static Builder<static>|Onsale wherePrice($value)
 * @method static Builder<static>|Onsale whereSalePrice($value)
 * @method static Builder<static>|Onsale whereSellerId($value)
 * @method static Builder<static>|Onsale whereShortDescription($value)
 * @method static Builder<static>|Onsale whereSku($value)
 * @method static Builder<static>|Onsale whereSlug($value)
 * @method static Builder<static>|Onsale whereSpecifications($value)
 * @method static Builder<static>|Onsale whereStockQuantity($value)
 * @method static Builder<static>|Onsale whereUpdatedAt($value)
 * @method static Builder<static>|Onsale whereUserId($value)
 * @method static Builder<static>|Onsale withMinDiscount(int $percent)
 * @mixin \Eloquent
 */
	class Onsale extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $order_number
 * @property int|null $user_id
 * @property int|null $seller_id
 * @property numeric $subtotal
 * @property numeric $tax_amount
 * @property numeric $total_price
 * @property string $status
 * @property string $payment_status
 * @property string|null $payment_method
 * @property string|null $payment_id
 * @property string $customer_name
 * @property string $customer_email
 * @property string|null $customer_phone
 * @property string $shipping_address
 * @property string $shipping_city
 * @property string $shipping_state
 * @property string $shipping_postal_code
 * @property string $shipping_country
 * @property string|null $billing_address
 * @property string|null $billing_city
 * @property string|null $billing_state
 * @property string|null $billing_postal_code
 * @property string|null $billing_country
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $shipped_at
 * @property \Illuminate\Support\Carbon|null $delivered_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $customer
 * @property-read string|null $display_email
 * @property-read string $display_name
 * @property-read mixed $full_shipping_address
 * @property-read string $payment_badge_classes
 * @property-read mixed $status_color
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderItem> $orderItems
 * @property-read int|null $order_items_count
 * @property-read \App\Models\Seller|null $seller
 * @property-read \App\Models\User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VendorOrder> $vendorOrders
 * @property-read int|null $vendor_orders_count
 * @method static Builder<static>|Order forUser($userId)
 * @method static Builder<static>|Order newModelQuery()
 * @method static Builder<static>|Order newQuery()
 * @method static Builder<static>|Order query()
 * @method static Builder<static>|Order search(?string $term)
 * @method static Builder<static>|Order whereBillingAddress($value)
 * @method static Builder<static>|Order whereBillingCity($value)
 * @method static Builder<static>|Order whereBillingCountry($value)
 * @method static Builder<static>|Order whereBillingPostalCode($value)
 * @method static Builder<static>|Order whereBillingState($value)
 * @method static Builder<static>|Order whereCreatedAt($value)
 * @method static Builder<static>|Order whereCustomerEmail($value)
 * @method static Builder<static>|Order whereCustomerName($value)
 * @method static Builder<static>|Order whereCustomerPhone($value)
 * @method static Builder<static>|Order whereDeliveredAt($value)
 * @method static Builder<static>|Order whereId($value)
 * @method static Builder<static>|Order whereNotes($value)
 * @method static Builder<static>|Order whereOrderNumber($value)
 * @method static Builder<static>|Order wherePaymentId($value)
 * @method static Builder<static>|Order wherePaymentMethod($value)
 * @method static Builder<static>|Order wherePaymentStatus($value)
 * @method static Builder<static>|Order whereSellerId($value)
 * @method static Builder<static>|Order whereShippedAt($value)
 * @method static Builder<static>|Order whereShippingAddress($value)
 * @method static Builder<static>|Order whereShippingCity($value)
 * @method static Builder<static>|Order whereShippingCountry($value)
 * @method static Builder<static>|Order whereShippingPostalCode($value)
 * @method static Builder<static>|Order whereShippingState($value)
 * @method static Builder<static>|Order whereStatus($value)
 * @method static Builder<static>|Order whereSubtotal($value)
 * @method static Builder<static>|Order whereTaxAmount($value)
 * @method static Builder<static>|Order whereTotalPrice($value)
 * @method static Builder<static>|Order whereUpdatedAt($value)
 * @method static Builder<static>|Order whereUserId($value)
 * @method static Builder<static>|Order withStatus($status)
 * @mixin \Eloquent
 */
	class Order extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $order_id
 * @property int $seller_id
 * @property int $product_id
 * @property string $product_name
 * @property string|null $product_sku
 * @property string|null $product_image
 * @property int $quantity
 * @property numeric $price
 * @property numeric $total
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Order $order
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\Seller $seller
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereProductImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereProductSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class OrderItem extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $user_id
 * @property int $seller_id
 * @property int $category_id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string|null $short_description
 * @property numeric $price
 * @property numeric|null $compare_price
 * @property numeric|null $sale_price
 * @property int $on_sale Indicates if the product is on sale
 * @property int $stock_quantity
 * @property int $page_views
 * @property string $sku
 * @property string|null $image
 * @property array<array-key, mixed>|null $gallery
 * @property string|null $images
 * @property array<array-key, mixed>|null $specifications
 * @property bool $is_featured
 * @property bool $is_active
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Review> $approvedReviews
 * @property-read int|null $approved_reviews_count
 * @property-read \App\Models\Category $category
 * @property-read \App\Models\User|null $creator
 * @property-read mixed $average_rating
 * @property-read mixed $current_price
 * @property-read int|null $discount_percent
 * @property-read mixed $discount_percentage
 * @property-read mixed $gallery_urls
 * @property-read mixed $has_image
 * @property-read mixed $image_url
 * @property-read mixed $images_urls
 * @property-read mixed $in_stock
 * @property-read mixed $is_on_sale
 * @property-read int|null $reviews_count
 * @property-read mixed $savings
 * @property-read mixed $stock_status
 * @property-read mixed $stock_status_color
 * @property-read mixed $thumbnail_url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderItem> $orderItems
 * @property-read int|null $order_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Review> $reviews
 * @property-read \App\Models\Seller $seller
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Wishlist> $wishlistItems
 * @property-read int|null $wishlist_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $wishlistedByUsers
 * @property-read int|null $wishlisted_by_users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product active()
 * @method static \Database\Factories\ProductFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product featured()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product inStock()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product onSale()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product search($term)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereComparePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereGallery($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereIsFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereOnSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product wherePageViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSalePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSpecifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereStockQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereUserId($value)
 * @mixin \Eloquent
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property int $rating 1-5 stars
 * @property string|null $comment
 * @property bool $is_approved
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $rating_stars
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review approved()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review search(?string $term)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereUserId($value)
 * @mixin \Eloquent
 */
	class Review extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $store_name
 * @property string $slug
 * @property string|null $description
 * @property string|null $business_document
 * @property string $status
 * @property string|null $admin_comment
 * @property string|null $store_logo
 * @property string|null $store_banner
 * @property string|null $contact_email
 * @property string|null $address
 * @property string|null $phone
 * @property string|null $website
 * @property string|null $facebook
 * @property string|null $instagram
 * @property string|null $tiktok
 * @property bool $ships_worldwide
 * @property int|null $returns_days
 * @property string|null $shipping_summary
 * @property string|null $response_time
 * @property \Illuminate\Support\Carbon|null $verified_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $followers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Category> $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $followers
 * @property-read string|null $business_document_url
 * @property-read string $store_banner_url
 * @property-read string $store_logo_url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read int|null $orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StoreReview> $receivedStoreReviews
 * @property-read int|null $received_store_reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StoreReview> $storeReviews
 * @property-read int|null $store_reviews_count
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VendorOrder> $vendorOrders
 * @property-read int|null $vendor_orders_count
 * @property-read \App\Models\Wallet|null $wallet
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller approved()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller pending()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereAdminComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereBusinessDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereContactEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereFollowersCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereInstagram($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereResponseTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereReturnsDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereShippingSummary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereShipsWorldwide($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereStoreBanner($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereStoreLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereStoreName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereTiktok($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereWebsite($value)
 * @mixin \Eloquent
 */
	class Seller extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $key
 * @property string|null $value
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereValue($value)
 * @mixin \Eloquent
 */
	class Setting extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $seller_id
 * @property int $user_id
 * @property string $comment
 * @property int $rating
 * @property int $on_sale Indicates if the product is on sale
 * @property bool $is_approved
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Seller $seller
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreReview approved()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreReview forSeller($sellerId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreReview newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreReview newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreReview query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreReview whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreReview whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreReview whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreReview whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreReview whereOnSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreReview whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreReview whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreReview whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreReview whereUserId($value)
 * @mixin \Eloquent
 */
	class StoreReview extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $role
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $profile_image
 * @property string $preferred_currency
 * @property string $preferred_language
 * @property string|null $timezone
 * @property int|null $timezone_offset
 * @property \Illuminate\Support\Carbon|null $last_active_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CartItem> $cartItems
 * @property-read int|null $cart_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ChatParticipant> $chatParticipants
 * @property-read int|null $chat_participants_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Chat> $chats
 * @property-read int|null $chats_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Seller> $followedSellers
 * @property-read int|null $followed_sellers_count
 * @property-read int $cart_count
 * @property-read mixed $total_unread_messages
 * @property-read int $wishlist_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read int|null $orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StoreReview> $receivedStoreReviews
 * @property-read int|null $received_store_reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Review> $reviews
 * @property-read int|null $reviews_count
 * @property-read \App\Models\Seller|null $seller
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ChatMessage> $sentMessages
 * @property-read int|null $sent_messages_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StoreReview> $storeReviews
 * @property-read int|null $store_reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \App\Models\Wallet|null $wallet
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Wishlist> $wishlistItems
 * @property-read int|null $wishlist_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $wishlistProducts
 * @property-read int|null $wishlist_products_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User online()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User recentlyActive()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastActiveAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePreferredCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePreferredLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereProfileImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTimezoneOffset($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property int|null $user_id
 * @property string $status
 * @property int $is_read
 * @property string|null $images
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserReport query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserReport whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserReport whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserReport whereIsRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserReport whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserReport whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserReport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserReport whereUserId($value)
 * @mixin \Eloquent
 */
	class UserReport extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $order_id
 * @property int $seller_id
 * @property numeric $subtotal
 * @property numeric $commission_rate
 * @property numeric $commission_amount
 * @property numeric $seller_earnings
 * @property string $status
 * @property string $payout_status
 * @property string|null $stripe_account_id
 * @property string|null $stripe_transfer_id
 * @property \Illuminate\Support\Carbon|null $paid_out_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderItem> $items
 * @property-read int|null $items_count
 * @property-read \App\Models\Order $order
 * @property-read \App\Models\Seller $seller
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorOrder whereCommissionAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorOrder whereCommissionRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorOrder whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorOrder wherePaidOutAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorOrder wherePayoutStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorOrder whereSellerEarnings($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorOrder whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorOrder whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorOrder whereStripeAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorOrder whereStripeTransferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorOrder whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorOrder whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class VendorOrder extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $seller_id
 * @property numeric $balance
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Seller $seller
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wallet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wallet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wallet query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wallet whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wallet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wallet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wallet whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wallet whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Wallet extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wishlist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wishlist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wishlist query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wishlist whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wishlist whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wishlist whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wishlist whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wishlist whereUserId($value)
 * @mixin \Eloquent
 */
	class Wishlist extends \Eloquent {}
}

