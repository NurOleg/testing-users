<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @OA\Post(
     *     operationId="create-user",
     *     path="/api/v1/user",
     *     tags={"User"},
     *     summary="Регистрация пользователя",
     *     @OA\RequestBody(required=true, @OA\MediaType(mediaType="application/json", @OA\Schema(
     *         required={"email"},
     *             @OA\Property(property="email", type="string", example="example@example.ru"),
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="password", type="string", example="password", minLength=8),
     *             @OA\Property(property="password_confirmation", type="string", example="password", minLength=8),
     *     ))),
     *     @OA\Response(
     *         response=201,
     *         description="User created",
     *         @OA\JsonContent(),
     *     ),
     *     @OA\Response(
     *          response=422,
     *          description="Unpocessable content",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="The FIELD_NAME field confirmation does not match."),
     *              @OA\Property(property="errors", type="object",
     *                  @OA\Property(property="FIELD_NAME", type="array",
     *                      @OA\Items(type="string")
     *                  ),
     *              ),
     *          ),
     *      ),
     * ),
     */
    public function create(UserRegisterRequest $request): JsonResponse
    {
        $user = new User();
        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->save();

        return new JsonResponse([], Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *     operationId="user-show",
     *     path="/api/v1/user/{user_id}",
     *     tags={"User"},
     *     summary="Получение пользователя",
     *     @OA\Parameter(name="user_id", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\Response(
     *         response=200,
     *         description="Success response",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/UserResource"),
     *         ),
     *     ),
     *     @OA\Response(
     *           response=404,
     *           description="User not found",
     *           @OA\JsonContent(
     *               type="object",
     *               @OA\Property(property="message", type="string", example="No query results for model [App\Models\User]"),
     *               @OA\Property(property="exception", type="string", example="Symfony\Component\HttpKernel\Exception\NotFoundHttpException"),
     *           ),
     *       ),
     * ),
     */
    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    /**
     * @OA\Get(
     *     operationId="user-list",
     *     path="/api/v1/user",
     *     tags={"User"},
     *     summary="Получение списка пользователей",
     *     @OA\Response(
     *         response=200,
     *         description="Success response",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      ref="#/components/schemas/UserResource"
     *                  )
     *              ),
     *            @OA\Property(property="links", ref="#/components/schemas/links"),
     *            @OA\Property(property="meta", ref="#/components/schemas/meta"),
     *         ),
     *     ),
     * ),
     */
    public function list(): AnonymousResourceCollection
    {
        $users = User::query()->simplePaginate(10);

        return UserResource::collection($users);
    }
}
