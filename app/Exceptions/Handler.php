<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Infrastructure\Utils\CustomLogger;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);

        $logPath = '';
        if ($exception instanceof ApiException) {
            $exception->getLogPath();
        }

        if (!empty($logPath)) {
            /** @var $customLog CustomLogger */
            $customLog = app(CustomLogger::class);
            $customLog->initialize($logPath);
            $customLog->error($exception->getMessage());
        }
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ApiException) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
        return parent::render($request, $exception);
    }
}
