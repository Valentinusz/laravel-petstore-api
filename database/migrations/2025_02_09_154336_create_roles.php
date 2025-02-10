<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \Spatie\Permission\Models\Permission::create(['name' => 'add pet']);

        Role::create(['name' => 'admin'])->givePermissionTo('add pet');
        Role::create(['name' => 'worker']);
        Role::create(['name' => 'user']);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
