<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShiftTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shift_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->time('graceTime')->nullable();;
            $table->string('daysOfWeek');
            $table->string('weekEnds');
            $table->time('startTime');
            $table->time('endTime');
            $table->time('lunchStartTime');
            $table->time('lunchEndTime');
            $table->date('startDate')->nullable();
            $table->date('endDate')->nullable();
            $table->boolean('isActive')->default(1);
            $table->boolean('isDefault')->default(1);
            $table->timestamps();
        });
    }
/*
CREATE TABLE `shift_types` (
`id` bigint(20) UNSIGNED NOT NULL,
`name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
`graceTime` bigint(20) UNSIGNED NOT NULL,
`daysOfWeek` bigint(20) UNSIGNED NOT NULL,
`weekEnds` bigint(20) UNSIGNED NOT NULL,
`startTime` bigint(20) UNSIGNED NOT NULL,
`endTime` bigint(20) UNSIGNED NOT NULL,
`lunchStartTime` bigint(20) UNSIGNED NOT NULL,
`lunchEndTime` bigint(20) UNSIGNED NOT NULL,
`startDate` bigint(20) UNSIGNED NOT NULL,
`endDate` bigint(20) UNSIGNED NOT NULL,
`isActive` bigint(20) UNSIGNED NOT NULL,
`isDefault` bigint(20) UNSIGNED NOT NULL,

`hrbp` bigint(20) UNSIGNED NOT NULL,
`shiftType_id` bigint(20) UNSIGNED NOT NULL,
`joiningDate` datetime NOT NULL,
`position_id` bigint(20) UNSIGNED NOT NULL,
`contactType` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
`taxResponsible` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
`paymentType_id` bigint(20) UNSIGNED NOT NULL,
`workingDays` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
`tin` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
`created_at` timestamp NULL DEFAULT NULL,
`updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

    */

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shift_types');
    }
}
