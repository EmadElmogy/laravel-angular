<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        // Deal with not found models as 404
        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        }

        if ($e instanceof ValidationException) {
            if ($request->ajax() || $request->is('api*') || $request->wantsJson()) {
                return response(['data' => null, 'error' => $e->getMessage()], 400);
            } else {
                return redirect()->back()->with('validationErrors', $e->getMessage())->withInput();
            }
        }

        // Handle 404
        if ($this->isHttpException($e)) {
            if ($request->ajax() || $request->is('api*') || $request->wantsJson()) {
                return response(['data' => null, 'error' => 'Resource not found.'], 404);
            } else {
                return response()->view('errors.404');
            }
        }

        // Handling all other exceptions
        if ($request->ajax() || $request->is('api*') || $request->wantsJson()) {
            return response(['data' => null, 'error' => $e->getMessage()], 500);
        } elseif (! config('app.debug')) {
            return response()->view('errors.500');
        }

        return parent::render($request, $e);
    }
}
