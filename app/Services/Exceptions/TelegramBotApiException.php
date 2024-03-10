<?php

namespace App\Services\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TelegramBotApiException extends Exception
{

  /*

   public function report() {

    }

   public function render(Request $request): JsonResponse
    {
        return response()->json(["error" => true, "message" => $this->getMessage()]);
    }
  */
}
