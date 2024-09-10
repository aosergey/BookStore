<?php
namespace App\Services;
use App\Models\Book;
use App\Models\Picture;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthService{
    public function create($validator){
        return User::create([
            'name' => $validator['name'],
            'email' => $validator['email'],
            'password' => Hash::make($validator['password'])
        ]);
    }
}
