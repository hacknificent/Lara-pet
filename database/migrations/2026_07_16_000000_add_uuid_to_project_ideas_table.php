<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('project_ideas', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->after('id')->unique();
        });

        $projectIdeas = DB::table('project_ideas')->whereNull('uuid')->get();

        foreach ($projectIdeas as $projectIdea) {
            DB::table('project_ideas')
                ->where('id', $projectIdea->id)
                ->update(['uuid' => (string) Str::uuid()]);
        }
    }

    public function down(): void
    {
        Schema::table('project_ideas', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
