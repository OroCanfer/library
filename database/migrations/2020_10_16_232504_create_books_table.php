<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('author');
            $table->date('publishDate');

            $table->foreignId('categoryId')->nullable();
            $table->foreignId('userId')->nullable();

            $table->timestamps();

            $table->foreign('categoryId')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
        });

        //Adding some books
        DB::table('books')->insert(
            array(
                'name' => 'The Lord of the Rings',
                'author' => 'J. R. R. Tolkien',
                'publishDate' => '1954-07-29',
                'categoryId' => 1,
                'created_at' => Carbon::now()
            )
        );

        DB::table('books')->insert(
            array(
                'name' => 'To Kill a Mockingbird',
                'author' => 'Harper Lee',
                'publishDate' => '1960-07-11',
                'categoryId' => 1,
                'created_at' => Carbon::now()
            )
        );

        DB::table('books')->insert(
            array(
                'name' => 'The Great Gatsby',
                'author' => 'F. Scott Fitzgerald',
                'publishDate' => '1925-04-10',
                'categoryId' => 1,
                'created_at' => Carbon::now()
            )
        );

        DB::table('books')->insert(
            array(
                'name' => 'One Hundred Years of Solitude',
                'author' => 'Gabriel García Márquez',
                'publishDate' => '1967-01-01',
                'categoryId' => 1,
                'created_at' => Carbon::now()
            )
        );

        DB::table('books')->insert(
            array(
                'name' => 'A Passage to India',
                'author' => 'E. M. Forster',
                'publishDate' => '1924-06-04',
                'categoryId' => 1,
                'created_at' => Carbon::now()
            )
        );

        DB::table('books')->insert(
            array(
                'name' => 'Invisible Man',
                'author' => 'Ralph Ellison',
                'publishDate' => '1952-04-14',
                'categoryId' => 1,
                'created_at' => Carbon::now()
            )
        );

        DB::table('books')->insert(
            array(
                'name' => 'Don Quixote',
                'author' => 'Miguel de Cervantes',
                'publishDate' => '1605-01-01',
                'categoryId' => 1,
                'created_at' => Carbon::now()
            )
        );

        DB::table('books')->insert(
            array(
                'name' => 'Beloved',
                'author' => 'Toni Morrison',
                'publishDate' => '1987-09-01',
                'categoryId' => 1,
                'created_at' => Carbon::now()
            )
        );

        DB::table('books')->insert(
            array(
                'name' => 'Mrs. Dalloway',
                'author' => 'Virginia Woolf',
                'publishDate' => '1924-04-14',
                'categoryId' => 1,
                'created_at' => Carbon::now()
            )
        );

        DB::table('books')->insert(
            array(
                'name' => 'Things Fall Apart',
                'author' => 'Chinua Achebe',
                'publishDate' => '1958-01-01',
                'categoryId' => 1,
                'created_at' => Carbon::now()
            )
        );

        DB::table('books')->insert(
            array(
                'name' => 'Jave Eyre',
                'author' => 'Charlotte Brontë',
                'publishDate' => '1847-10-16',
                'categoryId' => 1,
                'created_at' => Carbon::now()
            )
        );

        DB::table('books')->insert(
            array(
                'name' => 'The Color Purple',
                'author' => 'Alice Walker',
                'publishDate' => '1982-01-01',
                'categoryId' => 1,
                'created_at' => Carbon::now()
            )
        );

        DB::table('books')->orderBy('id')
        ->chunkById(100, function ($books) {
            foreach ($books as $book) {
                DB::table('categories')
                    ->where('id', $book->categoryId)
                    ->increment('manyBooks', 1);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('books');
    }
}
