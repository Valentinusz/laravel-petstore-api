<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Authentication")]
class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    #[OA\Post(
        path: "/login",
        operationId: "login",
        summary: "Log in",
        tags: ["Authentication"]
    )]
    #[OA\RequestBody(required: true, content: new OA\JsonContent(ref: "#/components/schemas/LoginRequest"))]
    #[OA\Response(response: 200, description: "OK", content: new OA\MediaType('application/json'))]
    public function store(LoginRequest $request): Response
    {
        $request->authenticate();

        $request->session()->regenerate();

        return response()->noContent();
    }

    /**
     * Destroy an authenticated session.
     */
    #[OA\Post(
        path: "/logout",
        operationId: "logout",
        summary: "Log out",
        tags: ["Authentication"]
    )]
    #[OA\Response(response: 204, description: "Session destroyed", content: new OA\MediaType('application/json'))]
    #[OA\Response(response: 401, description: "Not authenticated", content: new OA\MediaType('application/json'))]
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
