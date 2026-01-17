<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image',
        'role',
        'preferred_currency',
        'preferred_language',
        'slug',
        'last_active_at',
        'timezone',
        'timezone_offset',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_active_at' => 'datetime',
        'timezone_offset' => 'integer',
    ];

    public function getTimezone()
    {
        return $this->timezone ?? session('timezone', 'UTC');
    }

    public function formatInTimezone($datetime, $format = 'H:i')
    {
        if (!$datetime) return '';
        
        return Carbon::parse($datetime)
            ->setTimezone($this->getTimezone())
            ->format($format);
    }

    public function getCurrentTime($format = 'H:i')
    {
        return Carbon::now($this->getTimezone())->format($format);
    }

    public function toUserTimezone($datetime)
    {
        if (!$datetime) return null;
        
        return Carbon::parse($datetime)->setTimezone($this->getTimezone());
    }

    public function wishlistProducts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'wishlists', 'user_id', 'product_id');
    }

    public function wishlistItems(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function getWishlistCountAttribute(): int
    {
        return $this->wishlistItems()->count();
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function getCartCountAttribute(): int
    {
        return $this->cartItems()->count();
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
    
    public function storeReviews()
    {
        return $this->hasMany(StoreReview::class);
    }

    public function hasReviewedStore($sellerId)
    {
        return $this->storeReviews()->where('seller_id', $sellerId)->exists();
    }
    
    public function receivedStoreReviews()
    {
        return $this->hasMany(StoreReview::class, 'seller_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function hasInWishlist($productId): bool
    {
        return $this->wishlistItems()->where('product_id', $productId)->exists();
    }

    public function addToWishlist($productId)
    {
        return $this->wishlistItems()->firstOrCreate(['product_id' => $productId]);
    }

    public function removeFromWishlist($productId)
    {
        return $this->wishlistItems()->where('product_id', $productId)->delete();
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
    
    public function isSeller(): bool 
    {
        return $this->seller()->exists();
    }

    public function seller()
    {
        return $this->hasOne(Seller::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'user_id');
    }

    public function chats()
    {
        return $this->belongsToMany(Chat::class, 'chat_participants')
                    ->withPivot(['last_read_at'])
                    ->withTimestamps();
    }

    public function chatParticipants()
    {
        return $this->hasMany(ChatParticipant::class);
    }

    public function sentMessages()
    {
        return $this->hasMany(ChatMessage::class, 'sender_id');
    }

    public function getTotalUnreadMessagesAttribute()
    {
        return $this->chatParticipants()
            ->join('chat_messages', 'chat_messages.chat_id', '=', 'chat_participants.chat_id')
            ->where('chat_messages.sender_id', '!=', $this->id)
            ->where('chat_messages.created_at', '>', DB::raw('COALESCE(chat_participants.last_read_at, chat_participants.created_at)'))
            ->count();
    }
    
    public function findChatWith($userId)
    {
        return $this->chats()
            ->whereHas('participants', function($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->first();
    }
    
    public function startChatWith($userId)
    {
        $existingChat = $this->findChatWith($userId);
        if ($existingChat) {
            return $existingChat;
        }
        
        $chat = Chat::create(['type' => 'private']);
        
        $chat->participants()->createMany([
            ['user_id' => $this->id],
            ['user_id' => $userId]
        ]);
        
        return $chat;
    }
    
    public function getRecentChats($limit = 10)
    {
        return $this->chats()
            ->with(['lastMessage', 'participants.user'])
            ->withCount(['messages as unread_count' => function ($query) {
                $query->where('sender_id', '!=', $this->id)
                      ->where('is_read', false);
            }])
            ->orderByDesc(function ($query) {
                $query->select('created_at')
                    ->from('chat_messages')
                    ->whereColumn('chat_id', 'chats.id')
                    ->latest()
                    ->limit(1);
            })
            ->limit($limit)
            ->get();
    }
    
    public function updateLastActive()
    {
        $this->update(['last_active_at' => Carbon::now()]);
    }
    
    public function isOnline()
    {
        if (!$this->last_active_at) {
            return false;
        }
        return $this->last_active_at->gt(Carbon::now()->subMinutes(5));
    }

    public function getActivityStatus($viewerTimezone = null)
    {
        if ($this->isOnline()) {
            return 'Active now';
        }

        if (!$this->last_active_at) {
            return 'Offline';
        }

        $timezone = $viewerTimezone ?? $this->getTimezone();
        $lastActive = $this->last_active_at->setTimezone($timezone);
        $now = Carbon::now($timezone);
        
        $diff = $lastActive->diffInMinutes($now);
        
        if ($diff < 60) {
            return "Last seen " . round($diff) . "m ago";
        }
        
        $hours = floor($diff / 60);
        if ($hours < 24) {
            return "Last seen " . round($hours) . "h ago";
        }
        
        $days = floor($hours / 24);
        if ($days == 1) {
            return "Last seen yesterday at " . $lastActive->format('g:i a');
        }
        
        if ($days < 7) {
            return "Last seen " . round($days) . "d ago at " . $lastActive->format('g:i a');
        }
        
        if ($lastActive->year === $now->year) {
            return "Last seen " . $lastActive->format('M j \a\t g:i a');
        }
        
        return "Last seen " . $lastActive->format('M j, Y \a\t g:i a');
    }

    public function getChatActivityStatus($viewerTimezone = null)
    {
        if ($this->isOnline()) {
            return 'Online';
        }

        if (!$this->last_active_at) {
            return 'Offline';
        }

        $timezone = $viewerTimezone ?? $this->getTimezone();
        $lastActive = $this->last_active_at->setTimezone($timezone);
        $now = Carbon::now($timezone);
        
        $diff = $lastActive->diffInMinutes($now);
        
        if ($diff < 60) {
            // Round to nearest whole minute
            return "Active " . round($diff) . "m ago";
        }
        
        $hours = floor($diff / 60);
        if ($hours < 24) {
            return "Active " . round($hours) . "h ago";
        }
        
        $days = floor($hours / 24);
        if ($days < 7) {
            return "Active " . round($days) . "d ago";
        }
        
        return "Last seen recently";
    }

    public function scopeOnline($query)
    {
        return $query->where('last_active_at', '>', Carbon::now()->subMinutes(5));
    }

    public function scopeRecentlyActive($query)
    {
        return $query->where('last_active_at', '>', Carbon::now()->subHour());
    }

    public function formatMessageTime($timestamp, $viewerTimezone = null)
    {
        $timezone = $viewerTimezone ?? $this->getTimezone();
        $messageTime = Carbon::parse($timestamp)->setTimezone($timezone);
        $now = Carbon::now($timezone);
        
        if ($messageTime->isToday()) {
            return $messageTime->format('g:i a');
        }
        
        if ($messageTime->isYesterday()) {
            return 'Yesterday ' . $messageTime->format('g:i a');
        }
        
        if ($messageTime->diffInDays($now) < 7) {
            return $messageTime->format('D g:i a');
        }
        
        if ($messageTime->year === $now->year) {
            return $messageTime->format('M j, g:i a');
        }
        
        return $messageTime->format('M j, Y g:i a');
    }


    /**
     * Sellers followed by this user.
     */
    public function followedSellers()
    {
        return $this->belongsToMany(\App\Models\Seller::class, 'seller_followers', 'user_id', 'seller_id')
                    ->withTimestamps();
    }

    /**
     * Check if user is following given seller.
     */
    public function isFollowingSeller(\App\Models\Seller $seller): bool
    {
        return $this->followedSellers()->where('seller_id', $seller->id)->exists();
    }
}