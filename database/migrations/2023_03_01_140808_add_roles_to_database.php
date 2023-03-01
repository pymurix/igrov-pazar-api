<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    public function up(): void
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
    }

    public function down(): void
    {
        Role::where('name', 'admin')->delete();
        Role::where('name', 'user')->delete();
    }
};
