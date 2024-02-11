<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function addUser($data, $role)
    {
        return $this->create($data)->assignRole($role);
    }

    public function displayUser()
    {
        return $this->with('roles')->paginate(5);
    }

    public function editUser($id)
    {
        return $this->with('roles')->find($id);
    }

    public function updateUser($data, $id, $role)
    {
        $user = $this->find($id);
        $user->update($data);
        $user->syncRoles($role);
    }

    public function deleteUser($id)
    {
        $user = $this->find($id);
        $user->delete();
    }

    public function multipleDeleteUser($data)
    {
        $pricing = $this->whereIn('id', $data);
        $pricing->delete();
    }
}
