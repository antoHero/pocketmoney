<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('recipient_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade')->nullable();
            $table->foreignId('wallet_id')->constrained('wallets')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('type', ['Debit', 'Credit'])->nullable();
            $table->double('amount', 8,2);
            $table->string('reference')->nullable();
            $table->enum('status', ['Pending', 'Failed', 'Success'])->default('Pending')->nullable();
            $table->string('transaction_ref')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallet_transactions');
    }
}
