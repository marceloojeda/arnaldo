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
        if (!empty($data) and $data != '0000-00-00') {

            list($ano, $mes, $dia) = explode('-', substr(@$data, 0, 10));
            return $dia . '/' . $mes . '/' . $ano;
        }
        return 0;
    }

    public function calendarListBySeason(Request $request)
    {
        if (empty($request->input('season'))) {
            return response()->noContent();
        }

        try {



            $season = $request->input('season');
            $initialDate = '';
            if(!empty($request->input('inicio'))) {
                $arr = explode('/', $request->input('inicio'));
                $initialDate = $arr[2] . '-' . $arr[1] . '-' . $arr[0] . ' 00:00:00';
            }

            $finalDate = '';
            if(!empty($request->input('fim'))) {
                $arr = explode('/', $request->input('fim'));
                $finalDate = $arr[2] . '-' . $arr[1] . '-' . $arr[0] . ' 23:59:59';
            }
            $traducao = '';
            switch ($season) {
                case 'daily':
                    $initialDate = date('Y-m-d 00:00:00');
                    $finalDate = date('Y-m-d 23:59:59');
                    $traducao = 'do dia';
                    break;

                case 'weekly':
                    $week = $this->getWeekly();
                    $initialDate = $week[0];
                    $finalDate = $week[1];
                    $traducao = 'da semana';
                    break;

                case 'monthly':
                    $initialDate = date('Y-m-01 00:00:00');
                    $finalDate = date('Y-m-t 23:59:59');
                    $traducao = 'do mês';
                    break;

                case 'custom':
                    $initialDate = $initialDate ?? date('Y-m-d 00:00:00');
                    $finalDate = $finalDate ?? date('Y-m-d 23:59:59');
                    $traducao = 'do período';
                    break;

                default:
                    $week = $this->getWeekly();
                    $initialDate = $week[0];
                    $finalDate = $week[1];
                    $traducao = 'da semana';
                    break;
            }

            // if (env('APP_ENV') === 'local') {
            //     $initialDate = '2021-06-01 00:00:00';
            //     $finalDate = '2021-06-10 23:59:00';
            // }

            $calendars = Calendar::whereBetween(\DB::raw('DATE(data)'), [$initialDate, $finalDate])
                ->with('client')
                ->orderBy('data', 'desc')
                ->get();

            $key = 'valor';
            $sum = array_sum(array_column($calendars->toArray(), $key));

            $dataView = [
                'filtro' =>  $traducao,
                'results' => $calendars,
                'total' => $sum
            ];

            return view('rel_atendimentos_modal', ['dataView' => $dataView]);
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    private function getWeekly()
    {
        $date = null;
        $current = is_null($date)
            ? date('w')
            : date('w', strtotime($date));

        $now = is_null($date)
            ? strtotime('now')
            : strtotime($date);

        $week = [
            'dom' => '',
            'seg' => '',
            'ter' => '',
            'qua' => '',
            'qui' => '',
            'sex' => '',
            'sab' => ''
        ];

        $keys = array_keys($week);

        if ($current > 0) {
            $now = strtotime('-' . ($current) . ' day', $now);
        }

        for ($i = 0; $i < 7; $i++) {
            $week[$keys[$i]] = date('Y-m-d', strtotime("+$i day", $now));
        }

        return [$week['dom'], $week['sab']];
    }
}
