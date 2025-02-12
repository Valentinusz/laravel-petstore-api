<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $addPet = Permission::create(['name' => 'add pet']);
        $addAnimal = Permission::create(['name' => 'add animal']);

        Role::create(['name' => 'admin'])->givePermissionTo($addPet, $addAnimal);
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
