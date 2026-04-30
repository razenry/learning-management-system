<?php

namespace App\Core\Controllers;

use App\Http\Controllers\Controller;
use App\Core\Traits\ApiResponseTrait;

/**
 * @OA\Info(
 *     title="LMS Modular Monolith API",
 *     version="1.0.0",
 *     description="API Documentation for LMS Modular Monolith Backend"
 * )
 */
abstract class BaseController extends Controller
{
    use ApiResponseTrait;
}
