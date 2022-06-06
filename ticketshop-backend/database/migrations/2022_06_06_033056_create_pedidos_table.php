<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->bigIncrements('PedID');
            $table->integer('PedUsu');
            $table->integer('PedPro');
            $table->decimal('PedVrUnit',12,2);
            $table->float('PedCant',8,2);
            $table->decimal('PedSubtot',14,2);
            $table->float('PedIVA',12,2);
            $table->decimal('PedTotal',14,2);
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
        Schema::dropIfExists('pedidos');
    }
}
