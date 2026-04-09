<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $duplicates = DB::table('product_reviews')
            ->select('user_id', 'product_id', DB::raw('MIN(id) as keep_id'), DB::raw('COUNT(*) as duplicate_count'))
            ->groupBy('user_id', 'product_id')
            ->having('duplicate_count', '>', 1)
            ->get();

        foreach ($duplicates as $duplicate) {
            DB::table('product_reviews')
                ->where('user_id', $duplicate->user_id)
                ->where('product_id', $duplicate->product_id)
                ->where('id', '!=', $duplicate->keep_id)
                ->delete();
        }

        Schema::table('product_reviews', function (Blueprint $table) {
            $table->unique(['user_id', 'product_id'], 'product_reviews_user_product_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_reviews', function (Blueprint $table) {
            $table->dropUnique('product_reviews_user_product_unique');
        });
    }
};