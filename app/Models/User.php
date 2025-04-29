<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;

class User extends Authenticatable implements CanResetPassword
{
    use HasApiTokens, HasFactory, Notifiable, CanResetPasswordTrait;

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'nama',
        'no_telepon',
        'password',
        'nip',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat_rumah',
        'unit_kerja',
        'sk_perjanjian_kerja',
        'role',
        'status',
    ];

    /**
     * Hidden attributes.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Role checkers.
     */
    public function isPengawas()
    {
        return $this->role === 'pengawas';
    }

    public function isPengurus()
    {
        return $this->role === 'pengurus';
    }

    public function isAnggota()
    {
        return $this->role === 'anggota';
    }

    /**
     * Custom password reset notification.
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\ResetPasswordCustom($token));
    }
}
