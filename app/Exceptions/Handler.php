<?php

namespace App\Exceptions;

use Throwable;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function report(Throwable $exception)
    {
        if ($this->shouldReport($exception)) {
            $this->sendErrorEmail($exception);
        }

        parent::report($exception);
    }

    private function sendErrorEmail(Throwable $exception)
    {
        $errorMessage = $exception->getMessage();
        $errorTrace = $exception->getTraceAsString();
        $user = Auth::user();
        $date = Carbon::now()->format('d-m-Y H:i');;
        $userName = $user ? $user->name : 'Utente non identificato';
        
        Mail::raw("User: $userName il giorno: $date\n\nError Message: $errorMessage\n\nStack Trace: $errorTrace", function ($message) {
            $message->to('root@coimaf.com')->subject('Errore in Dashboard Coimaf!');
        });
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
{
    if ($exception instanceof ModelNotFoundException || $exception instanceof NotFoundHttpException) {

        return response()->view('Errors.notFound', [], 404);
    }

    return parent::render($request, $exception);
}
}
