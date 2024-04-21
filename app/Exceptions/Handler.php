<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
        RestException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

        /**
     * Render the exception into an HTTP response.
     * Target exception orrcured while handling a request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $e)
    {

        Log::debug('======================================');
        Log::debug('Exception instance of ' . get_class($e));
        Log::debug('Message: ' . $e->getMessage());
        Log::debug('Code: ' . $e->getCode());
        Log::debug('======================================');

        // Validation exception
        if ($e instanceof ValidationException) {
            Log::debug('ValidationException: ' . $e->getMessage());
            // Log::debug(json_encode($e, 256));
            // Log::debug(json_encode($e->getMessage(), 256));
            $messages = collect($e->validator->getMessageBag()->getMessages())->collapse();
            Log::debug("messages: " . json_encode($messages, 256));
            // Log::debug("messages2: " . json_encode($e->validator->getMessageBag()->getMessages(), 256));
            // return $this->errorResponse($messages->first(), Response::HTTP_BAD_REQUEST);
        }




        // Handle other exceptions
        return parent::render($request, $e);
    }

}
