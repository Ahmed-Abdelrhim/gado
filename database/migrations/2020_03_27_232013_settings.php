<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Setting;

class Settings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->longText('tagged')->nullable();
            $table->longText('copyrigth')->nullable();
            $table->longText('about_ar')->nullable();
            $table->longText('about_en')->nullable();
            $table->longText('policy_ar')->nullable();
            $table->longText('why_us_ar')->nullable();
            $table->longText('why_us_en')->nullable();
            $table->float('tax_rate')->nullable();
            $table->float('dilivary')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->timestamps();
        });

        $setting = new Setting;
        $setting->name  = 'إسم التطبيق';
        $setting->email = 'mohamed.hamada0103@gmail.com';
        $setting->phone = '01068549674';
        $setting->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
