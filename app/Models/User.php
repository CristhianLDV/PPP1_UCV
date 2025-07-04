<?php


namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'password', 'pin_code'];
    
    protected $hidden = ['password', 'remember_token', 'pin_code'];
    
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relación muchos a muchos con roles
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_users', 'user_id', 'role_id');
    }

    // Verifica si el usuario tiene un rol
    public function hasRole($role)
    {
        return $this->roles()->where('slug', $role)->exists();
    }

    // Verifica si el usuario tiene alguno de los roles proporcionados
    public function hasAnyRole($roles)
    {
        return $this->roles()->whereIn('slug', (array) $roles)->exists();
    }
}