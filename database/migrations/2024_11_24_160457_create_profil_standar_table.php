<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilStandarTable extends Migration
{
    public function up()
    {
        Schema::create('profil_standar', function (Blueprint $table) {
            $table->id();
            $table->integer('slik')->default(4);
            $table->integer('pendapatan_utama')->default(3);
            $table->integer('pendapatan_lain')->default(3);
            $table->integer('modal')->default(3);
            $table->integer('aset')->default(4);
            $table->integer('tanggungan')->default(4);
            $table->integer('biaya_lain')->default(5);
            $table->integer('bpkb')->default(3);
            $table->integer('shm')->default(3);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profil_standar');
    }
};
