<?php

namespace App\Http\Controllers\Auth;

use App\User; // Update the namespace to match your User model location
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str; // Import the Str class for generating random strings
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        $request = request();
        $img_path = null;
        if ($request->hasFile('imgupload')) {
            $files = $request->file('imgupload');
            $file = $request->file('imgupload')->getClientOriginalName();
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $path = $filename . '-' . time() . '.' . $files->getClientOriginalExtension();
            $destinationPath = storage_path('/imgs/user_avatar/');
            $files->move($destinationPath, $path);
            $img_path = $path;
        }
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'telephone' => $data['tel'], // Assuming 'tel' is part of your form data
            'avatar' => $img_path,
            'token' => Str::random(16), // Use Str::random() to generate random string
        ]);
    }
}
