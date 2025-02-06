<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 *  @OA\Schema(
 *     schema="UserResource",
 *     @OA\Property(property="id", type="integer", example="1", nullable=false),
 *     @OA\Property(property="name", type="string", example="John Doe", nullable=false),
 *     @OA\Property(property="email", type="string", example="John@Doe.com", nullable=false),
 *     @OA\Property(property="created_at", ref="#/components/schemas/datetime"),
 *     @OA\Property(property="updated_at", ref="#/components/schemas/datetime"),
 * ),
 */
final class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var User $resource **/
        $resource = $this->resource;

        return [
            'id' => $resource->id,
            'name' => $resource->name,
            'email' => $resource->email,
            'created_at' => $resource->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $resource->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
