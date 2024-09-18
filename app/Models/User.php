<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Guru;


class User extends Authenticatable {
  // use HasFactory, Notifiable;
  
  protected $fillable = [ 'name', 'username', 'role', 'email', 'password', ];

  protected $hidden = [ 'password', 'remember_token', ];

  // Relasi one-to-one dengan model Guru
  public function guru() {
    return $this->hasOne(Guru::class);
  }

  protected function casts(): array {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }
}