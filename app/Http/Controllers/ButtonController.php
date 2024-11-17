<?php

namespace App\Http\Controllers;

use App\Events\ButtonStatusChanged;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ButtonController extends Controller
{
    public function changeButtonStatus(Request $request){
        $color = $request->input('color');
        Log::info('color is '.$color);
        // Trigger the event to broadcast the color change
        broadcast(new ButtonStatusChanged($color));
        // Return a JSON response
        return response()->json(['success' => true, 'color' => $color]);
    }
}
