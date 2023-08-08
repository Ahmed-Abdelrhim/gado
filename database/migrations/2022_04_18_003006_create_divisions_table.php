<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Division;
class CreateDivisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('divisions', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->string('image');
            $table->string('logo')->nullable();
            $table->string('color')->nullable();
            $table->timestamps();
        });

        $Division = new Division;
        $Division->name_ar ='متجر التكييفات';
        $Division->name_en ='Air conditioner store';
        $Division->image ='v-2.svg';
        $Division->save();

        $Division = new Division;
        $Division->name_ar ='العدد والأدوات اليدوية';
        $Division->name_en ='Tools and hand tools';
        $Division->image ='v-1.svg';
        $Division->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('divisions');
    }
}
