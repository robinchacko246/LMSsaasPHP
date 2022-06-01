<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewFieldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'stores', function (Blueprint $table){
            $table->string('invoice_logo')->nullable()->after('logo');
            $table->string('blog_enable')->default('on')->after('enable_rating');
        }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(
            'stores', function (Blueprint $table){
            $table->dropColumn('invoice_logo');
            $table->dropColumn('blog_enable');
        }
        );
    }
}
