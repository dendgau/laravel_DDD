<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Response\JsonResponseCustom;
use Infrastructure\Utils\CustomLogger;
use Exception;
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
     * @param Throwable $exception
     * @return void
     *
     * @throws Exception
     * @throws Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);

        // Setup log path
        $logPath = null;
        $message = null;
        $data = [];
        if ($exception instanceof ApiException ||
            $exception instanceof ValidationException ||
            $exception instanceof BusinessException ||
            $exception instanceof ConsoleException ||
            $exception instanceof ApplicationException
        ) {
            $logPath = $exception->getLogPath();
            $message = $exception->getLogMessage();
            $data = $exception->getData();
        }

        /** @var $customLog CustomLogger */
        $customLog = app(CustomLogger::class);

        if ($logPath) {
            $customLog->initialize($logPath);
            $customLog->error($message ?? $exception->getMessage(), $data);
        }
        $customLog->uninitialized();
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request  $request
     * @param Throwable $exception
     * @return Response
     *
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($request->is('api/*') || $request->wantsJson()) {
            return JsonResponseCustom::create(true, [], $exception->getMessage(), 500);
        }
        return parent::render($request, $exception);
    }
}
