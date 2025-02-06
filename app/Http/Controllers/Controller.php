<?php

declare(strict_types=1);

namespace App\Http\Controllers;

/**
 * @OA\Info(title="users", version="0.0.1")
 * @OA\Schema(schema="datetime", type="string", example="2025-02-06 21:25:49")
 * @OA\Schema(schema="links", type="object",
 *      @OA\Property(property="first", type="string", example="http://localhost/api/v1/user?page=1"),
 *      @OA\Property(property="last", type="string", example="http://localhost/api/v1/user?page=15", nullable="true"),
 *      @OA\Property(property="prev", type="string", example="http://localhost/api/v1/user?page=1", nullable="true"),
 *      @OA\Property(property="next", type="string", example="http://localhost/api/v1/user?page=2", nullable="true"),
 * )
 * @OA\Schema(schema="meta", type="object",
 *       @OA\Property(property="current_page", type="integer", example="1"),
 *       @OA\Property(property="from", type="integer", example="1"),
 *       @OA\Property(property="path", type="string", example="http://localhost/api/v1/user"),
 *       @OA\Property(property="per_page", type="integer", example="1"),
 *       @OA\Property(property="to", type="integer", example="3"),
 *  )
 */
abstract class Controller
{
    //
}
