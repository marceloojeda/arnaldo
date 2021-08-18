<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use Illuminate\Http\Request;

class CalendarController extends Controller
{

    public function edit($id)
    {
        $calendar = Calendar::with('client')->find($id);
        $arrCalendar = $calendar->toArray();
        $arrCalendar['data'] = $this->toDateBr($calendar->data);
        return response()->json($arrCalendar);
    }

    public function update(Request $request, Calendar $calendar)
    {
        //
    }

    private function toDateBr($data = '')
    {
        if (!empty($data) AND $data != '0000-00-00') {

            list($ano, $mes, $dia) = explode('-', substr(@$data, 0, 10));
            return $dia . '/' . $mes . '/' . $ano;
        }
        return 0;

    }
}
