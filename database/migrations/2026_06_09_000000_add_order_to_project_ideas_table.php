<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('project_ideas', function (Blueprint $table) {
            $table->double('order')->default(0)->after('status');
        });

        // Initialize existing ideas with spaced order values.
        $ideas = DB::table('project_ideas')
            ->orderBy('status')
            ->orderBy('id')
            ->get();

        $positions = [];
        foreach ($ideas as $idea) {
            $status = $idea->status;
            if (! isset($positions[$status])) {
                $positions[$status] = 1.0;
            }
            DB::table('project_ideas')
                ->where('id', $idea->id)
                ->update(['order' => $positions[$status]]);
            $positions[$status] += 1.0;
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_ideas', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }
};
