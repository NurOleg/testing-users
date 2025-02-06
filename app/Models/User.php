<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 * @property string $email
 * @property string $name
 * @property string $password
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
final class User extends Authenticatable
{
    use HasFactory;
}
