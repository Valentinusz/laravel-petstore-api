<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;

return new class extends Migration {
    /**
     * Name of permissions to add.
     * @var array<string>
     */
    private array $permissionNames = [
        'read pet',
        'add pet',
        'update pet',
        'delete pet',
        'read animal',
        'add animal',
        'update animal',
        'delete animal'
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        collect($this->permissionNames)->each(fn(string $permission) => Permission::create([
            'name' => $permission,
        ]));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Permission::where('name', 'in', $this->permissionNames)->each(fn(Permission $permission) => $permission->delete());
    }
};
