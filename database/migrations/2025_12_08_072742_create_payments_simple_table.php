<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Nullable pour permettre les paiements sans authentification
            $table->string('reference')->unique();
            $table->string('fedapay_id')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('currency')->default('XOF');
            $table->string('status')->default('pending');
            $table->string('payment_method')->nullable();
            $table->text('description')->nullable();
            $table->text('customer_info')->nullable();
            $table->text('metadata')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            
            // Clé étrangère optionnelle (seulement si user_id n'est pas null)
            // On ne peut pas créer une clé étrangère nullable directement, donc on laisse sans contrainte
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};