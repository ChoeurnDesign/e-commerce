<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payout_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('seller_id')
                ->constrained('sellers')
                ->cascadeOnDelete();

            // Amount the seller is requesting to withdraw.
            $table->decimal('amount', 10, 2);

            // Bank info entered by the seller for THIS payout.
            $table->string('bank_name');
            $table->string('account_name');
            $table->string('account_number');
            $table->string('phone')->nullable();           // for wallets like Wing/Pi Pay
            $table->text('seller_note')->nullable();       // optional message from seller

            // Status lifecycle
            $table->enum('status', ['pending', 'approved', 'paid', 'rejected'])
                ->default('pending');

            // Admin who acted on the request
            $table->unsignedBigInteger('processed_by')->nullable();
            $table->timestamp('processed_at')->nullable();

            // Bank transaction reference from admin's banking app
            $table->string('transaction_reference')->nullable();
            $table->text('admin_note')->nullable();

            $table->timestamps();

            $table->index(['seller_id', 'status']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payout_requests');
    }
};
