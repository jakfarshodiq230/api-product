<?php
namespace App\Documentation\Schemas;
/**
 * @OA\Schema(
 *     schema="User",
 *     title="User",
 *     required={"id", "name", "email"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 *     @OA\Property(property="hair", ref="#/components/schemas/Hair"),
 *     @OA\Property(property="address", ref="#/components/schemas/Address"),
 *     @OA\Property(property="bank", ref="#/components/schemas/Bank"),
 *     @OA\Property(property="company", ref="#/components/schemas/Company"),
 *     @OA\Property(property="crypto", ref="#/components/schemas/Crypto")
 * )
 *
 * @OA\Schema(
 *     schema="Hair",
 *     title="Hair Details",
 *     @OA\Property(property="color", type="string", example="Black"),
 *     @OA\Property(property="type", type="string", example="Straight")
 * )
 *
 * @OA\Schema(
 *     schema="Address",
 *     title="User Address",
 *     @OA\Property(property="street", type="string", example="123 Main St"),
 *     @OA\Property(property="city", type="string", example="New York"),
 *     @OA\Property(property="postal_code", type="string", example="10001")
 * )
 *
 * @OA\Schema(
 *     schema="Bank",
 *     title="Bank Account",
 *     @OA\Property(property="card_number", type="string", example="4111111111111111"),
 *     @OA\Property(property="bank_name", type="string", example="Bank Central")
 * )
 *
 * @OA\Schema(
 *     schema="Company",
 *     title="Company Details",
 *     @OA\Property(property="name", type="string", example="Acme Inc"),
 *     @OA\Property(property="position", type="string", example="Software Developer")
 * )
 *
 * @OA\Schema(
 *     schema="Crypto",
 *     title="Crypto Wallet",
 *     @OA\Property(property="wallet_address", type="string", example="0x71C7656EC7ab88b098defB751B7401B5f6d8976F"),
 *     @OA\Property(property="coin_type", type="string", example="ETH")
 * )
 */
class UserSchema {}
