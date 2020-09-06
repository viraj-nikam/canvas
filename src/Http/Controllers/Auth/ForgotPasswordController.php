<?php

namespace Canvas\Http\Controllers\Auth;

use Canvas\Mail\ResetPassword;
use Canvas\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ForgotPasswordController extends Controller
{
    /**
     * Display the form to request a password reset link.
     *
     * @return Application|Factory|View
     */
    public function showLinkRequestForm()
    {
        return view('canvas::auth.passwords.email');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param Request $request
     * @return RedirectResponse|JsonResponse
     * @throws Exception
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        $user = User::firstWhere('email', $request->email);
        $token = Str::random();

        if ($user) {
            cache(["password.reset.{$user->id}" => $token],
                now()->addMinutes(60)
            );

            Mail::to($user->email)->send(new ResetPassword(encrypt("{$user->id}|{$token}")));
        }

        return redirect()->route('canvas.password.request')->with('status', 'We have emailed your password reset link!');
    }

    /**
     * Validate the email for the given request.
     *
     * @param Request $request
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:canvas_users']);
    }
}
