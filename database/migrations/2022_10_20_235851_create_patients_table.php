<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
  */
  public function up()
  {
    Schema::create('patients', function (Blueprint $table) {
      $table->id();
      $table->string('name', 100);
      $table->string('address', 50);
      $table->string('rg', 50);
      $table->string('cpf', 50);
      $table->date('birth_date');
      $table->string('telephone', 50);
      $table->string('time_service');
      $table->string('consultation', 100);
      $table->string('marital_status', 100)->nullable();
      $table->string('house_number', 100);
      $table->string('Complement', 100);
      $table->string('district', 100);
      $table->string('city', 100);
      $table->string('name_father', 100)->nullable();
      $table->string('address_father', 100)->nullable();
      $table->string('city_father', 100)->nullable();
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
    Schema::dropIfExists('patients');
  }
};
