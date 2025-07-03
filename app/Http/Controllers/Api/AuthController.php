<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Use the 'api' guard for JWT authentication
        if (! $token = Auth::guard('api')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    // List all users
    public function index()
    {
        // Mengambil semua data user dari model User
        
    }

    // Show user profile (detail)
    public function show($id)
    {
        $user = User::with(['hair', 'address', 'bank', 'company', 'crypto'])->find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        return response()->json([
            'message' => 'Profil user berhasil diambil',
            'user' => $user
        ],200);
    }

    // Register new user (with additional fields)
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string|max:100',
            'lastName' => 'required|string|max:100',
            'maidenName' => 'nullable|string|max:100',
            'age' => 'required|integer|min:0',
            'gender' => 'required|string|in:male,female,other',
            'email' => 'required|string|email|max:100|unique:users,email',
            'phone' => 'required|string|max:20',
            'username' => 'required|string|max:100|unique:users,username',
            'password' => 'required|string|min:6',
            'birthDate' => 'required|date',
            'image' => 'nullable|string',
            'bloodGroup' => 'nullable|string|max:10',
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'eyeColor' => 'nullable|string|max:50',
            'ip' => 'nullable|string|max:50',
            'macAddress' => 'nullable|string|max:50',
            'university' => 'nullable|string|max:255',
            'ein' => 'nullable|string|max:50',
            'ssn' => 'nullable|string|max:50',
            'userAgent' => 'nullable|string|max:255',
            // Hair
            'hair.color' => 'required|string|max:50',
            'hair.type' => 'required|string|max:50',
            // Address
            'address.address' => 'required|string|max:255',
            'address.city' => 'required|string|max:100',
            'address.state' => 'required|string|max:100',
            'address.stateCode' => 'required|string|max:10',
            'address.postalCode' => 'required|string|max:20',
            'address.country' => 'required|string|max:100',
            'address.coordinates.lat' => 'required|numeric',
            'address.coordinates.lng' => 'required|numeric',
            // Bank
            'bank.cardExpire' => 'nullable|string|max:10',
            'bank.cardNumber' => 'nullable|string|max:30',
            'bank.cardType' => 'nullable|string|max:30',
            'bank.currency' => 'nullable|string|max:10',
            'bank.iban' => 'nullable|string|max:50',
            // Company
            'company.name' => 'nullable|string|max:255',
            'company.department' => 'nullable|string|max:100',
            'company.title' => 'nullable|string|max:100',
            'company.address.address' => 'nullable|string|max:255',
            'company.address.city' => 'nullable|string|max:100',
            'company.address.state' => 'nullable|string|max:100',
            'company.address.stateCode' => 'nullable|string|max:10',
            'company.address.postalCode' => 'nullable|string|max:20',
            'company.address.country' => 'nullable|string|max:100',
            'company.address.coordinates.lat' => 'nullable|numeric',
            'company.address.coordinates.lng' => 'nullable|numeric',
            // Crypto
            'crypto.coin' => 'nullable|string|max:50',
            'crypto.wallet' => 'nullable|string|max:100',
            'crypto.network' => 'nullable|string|max:100',
            // Role
            'role' => 'nullable|string|max:20',
        ], [], [
            'firstName' => 'First Name',
            'lastName' => 'Last Name',
            'maidenName' => 'Maiden Name',
            'age' => 'Age',
            'gender' => 'Gender',
            'email' => 'Email',
            'phone' => 'Phone',
            'username' => 'Username',
            'password' => 'Password',
            'birthDate' => 'Birth Date',
            'hair.color' => 'Hair Color',
            'hair.type' => 'Hair Type',
            'address.address' => 'Address',
            'address.city' => 'City',
            'address.state' => 'State',
            'address.stateCode' => 'State Code',
            'address.postalCode' => 'Postal Code',
            'address.country' => 'Country',
            'address.coordinates.lat' => 'Latitude',
            'address.coordinates.lng' => 'Longitude',
        ]);

        if ($validator->fails()) {
            // Convert Laravel validation keys to dot notation for nested fields
            $errors = [];
            foreach ($validator->errors()->getMessages() as $key => $messages) {
                $errors[$key] = $messages;
            }
            return response()->json($errors, 422);
        }

        $data = $validator->validated();

        // Create user
        $user = User::create([
            'first_name' => $data['firstName'],
            'last_name' => $data['lastName'],
            'maiden_name' => $data['maidenName'] ?? null,
            'age' => $data['age'],
            'gender' => $data['gender'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'birth_date' => $data['birthDate'],
            'image' => $data['image'] ?? 'https://dummyjson.com/icon/' . $data['username'] . '/128',
            'blood_group' => $data['bloodGroup'] ?? null,
            'height' => $data['height'] ?? null,
            'weight' => $data['weight'] ?? null,
            'eye_color' => $data['eyeColor'] ?? null,
            'ip' => $data['ip'] ?? null,
            'mac_address' => $data['macAddress'] ?? null,
            'university' => $data['university'] ?? null,
            'ein' => $data['ein'] ?? null,
            'ssn' => $data['ssn'] ?? null,
            'user_agent' => $data['userAgent'] ?? null,
            'role' => $data['role'] ?? 'user',
        ]);

        // Hair
        $user->hair()->create([
            'color' => $data['hair']['color'],
            'type' => $data['hair']['type'],
        ]);

        // Address & coordinates
        $address = $user->address()->create([
            'address' => $data['address']['address'],
            'city' => $data['address']['city'],
            'state' => $data['address']['state'],
            'state_code' => $data['address']['stateCode'],
            'postal_code' => $data['address']['postalCode'],
            'country' => $data['address']['country'],
        ]);
        $address->coordinates()->create([
            'lat' => $data['address']['coordinates']['lat'],
            'lng' => $data['address']['coordinates']['lng'],
        ]);

        // Bank
        if (!empty($data['bank'] ?? [])) {
            $user->bank()->create([
                'card_expire' => $data['bank']['cardExpire'] ?? '12/25',
                'card_number' => $data['bank']['cardNumber'] ?? '1234567890123456',
                'card_type' => $data['bank']['cardType'] ?? 'Visa',
                'currency' => $data['bank']['currency'] ?? 'USD',
                'iban' => $data['bank']['iban'] ?? 'US1234567890123456789',
            ]);
        }

        // Company
        if (!empty($data['company'] ?? [])) {
            $company = $user->company()->create([
                'name' => $data['company']['name'] ?? 'Default Company',
                'department' => $data['company']['department'] ?? 'Default Department',
                'title' => $data['company']['title'] ?? 'Default Title',
            ]);
            if (!empty($data['company']['address'] ?? [])) {
                $companyAddress = $company->address()->create([
                    'address' => $data['company']['address']['address'] ?? '123 Default St',
                    'city' => $data['company']['address']['city'] ?? 'Default City',
                    'state' => $data['company']['address']['state'] ?? 'Default State',
                    'state_code' => $data['company']['address']['stateCode'] ?? 'DS',
                    'postal_code' => $data['company']['address']['postalCode'] ?? '12345',
                    'country' => $data['company']['address']['country'] ?? 'Default Country',
                ]);
                if (!empty($data['company']['address']['coordinates'] ?? [])) {
                    $companyAddress->coordinates()->create([
                        'lat' => $data['company']['address']['coordinates']['lat'] ?? 0.00,
                        'lng' => $data['company']['address']['coordinates']['lng'] ?? 0.00,
                    ]);
                }
            }
        }

        // Crypto
        if (!empty($data['crypto'] ?? [])) {
            $user->crypto()->create([
                'coin' => $data['crypto']['coin'] ?? 'Bitcoin',
                'wallet' => $data['crypto']['wallet'] ?? null,
                'network' => $data['crypto']['network'] ?? null,
            ]);
        }

        return response()->json([
            'message' => 'User berhasil dibuat',
            'user' => $user->load(['hair', 'address.coordinates', 'bank', 'company.address.coordinates', 'crypto'])
        ], 201);
    }

    public function logout() {
        Auth::logout();
        return response()->json(['message' => 'User successfully signed out']);
    }

    public function refresh() {
        return $this->respondWithToken(Auth::refresh());
    }

    public function userProfile() {
        return response()->json(Auth::user());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'status' => 'success',
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
                'expires_in' => config('jwt.ttl') * 60 // Menggunakan config langsung
            ]
        ]);
    }
}
