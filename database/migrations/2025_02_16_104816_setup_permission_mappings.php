<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Name of permissions to add for admin users.
     * @var array<string>
     */
    private array $permissionNamesForAdmin = [
        'read pet',
        'add pet',
        'update pet',
        'delete pet',
        'read animal',
        'add animal',
        'update animal',
        'delete animal',
        'read adoption',
        'store adoption',
        'update adoption',
        'delete adoption'
    ];

    /**
     * Name of permissions to add for worker users.
     * @var array<string>
     */
    private array $permissionNamesForWorker = [
        'read pet',
        'add pet',
        'update pet',
        'delete pet',
        'read animal',
        'add animal',
        'update animal',
        'delete animal',
        'read adoption',
        'store adoption',
        'update adoption',
        'delete adoption'
    ];

    /**
     * Name of permissions to add for regular users.
     * @var array<string>
     */
    private array $permissionNamesForUser = [
        'read pet',
        'read animal'
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $admin = Role::findByName('admin');
        $worker = Role::findByName('worker');
        $user = Role::findByName('user');

        $admin->givePermissionTo($this->permissionNamesForAdmin);
        $worker->givePermissionTo($this->permissionNamesForWorker);
        $user->givePermissionTo($this->permissionNamesForUser);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $admin = Role::findByName('admin');
        $worker = Role::findByName('worker');
        $user = Role::findByName('user');

        $admin->revokePermissionTo($this->permissionNamesForAdmin);
        $worker->revokePermissionTo($this->permissionNamesForWorker);
        $user->revokePermissionTo($this->permissionNamesForUser);
    }
};
