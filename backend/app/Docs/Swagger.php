<?php

namespace App\Docs;

/**
 * @OA\Info(
 *     title="Language Learning API",
 *     version="1.0.0",
 *     description="API documentation for the language learning application"
 * )
 *
 * @OA\Server(
 *     url="http://127.0.0.1:8000",
 *     description="Local server"
 * )
 *
 * @OA\Post(
 *     path="/api/login",
 *     summary="Login user",
 *     tags={"Auth"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email","password"},
 *             @OA\Property(property="email", type="string", example="test@example.com"),
 *             @OA\Property(property="password", type="string", example="password123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Login successful"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Invalid credentials"
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/register",
 *     summary="Register user",
 *     tags={"Auth"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name","email","password"},
 *             @OA\Property(property="name", type="string", example="Teodora"),
 *             @OA\Property(property="email", type="string", example="teodora@example.com"),
 *             @OA\Property(property="password", type="string", example="password123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Registration successful"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/courses",
 *     summary="Get all courses",
 *     tags={"Courses"},
 *     @OA\Response(
 *         response=200,
 *         description="List of courses"
 *     )
 * )
 */
class Swagger {}