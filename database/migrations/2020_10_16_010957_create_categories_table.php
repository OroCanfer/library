<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('description');
            $table->integer('manyBooks')->default(0);

            $table->timestamps();
        });

        //Adding some categories
        DB::table('categories')->insert(
            array(
                'name' => 'Fantasy',
                'description' => '',
                'manyBooks' => 0,
                'created_at' => Carbon::now()
            )
        );

        DB::table('categories')->insert(
            array(
                'name' => 'Horror',
                'description' => '',
                'manyBooks' => 0,
                'created_at' => Carbon::now()
            )
        );

        DB::table('categories')->insert(
            array(
                'name' => 'Graphic novel',
                'description' => '',
                'manyBooks' => 0,
                'created_at' => Carbon::now()
            )
        );

        DB::table('categories')->insert(
            array(
                'name' => 'Detective and mistery',
                'description' => '',
                'manyBooks' => 0,
                'created_at' => Carbon::now()
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('categories');
    }
}
