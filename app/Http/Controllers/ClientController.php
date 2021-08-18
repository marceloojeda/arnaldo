<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    private $rules;

    public function __construct()
    {
        $this->rules = [
            'nome' => 'required|max:255',
            'fone' => 'required|max:20'
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clients = Client::where('deleted_at', null);
        if ($request->input('nome')) {
            $clients->whereRaw("lower(nome) like '%" . strtolower($request->input('nome')) . "%'");
        }

        return view('clients', ['clients' => $clients->orderBy('nome')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $params = [
            'dataAtual' => date('d/m/Y')
        ];
        return View('client_add', ['params' => $params]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        $arrCliente = $request->except('_token');
        if (!empty($arrCliente['data_nascimento'])) {
            $arrCliente['data_nascimento'] = $this->toDateBanco($arrCliente['data_nascimento']);
        }
        if (!empty($arrCliente['data_adesao'])) {
            $arrCliente['data_adesao'] = $this->toDateBanco($arrCliente['data_adesao']);
        }

        $client = Client::create($arrCliente);
        $client->refresh();
        return redirect('/clients');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        $client->atendimentos = Calendar::where('client_id', $client->id)->orderBy('data', 'desc')->get();

        return View('calendar', ['client' => $client]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        $arrCliente = $client->toArray();
        if (!empty($client->data_nascimento)) {
            $arrCliente['data_nascimento'] = $this->toDateBrasil($client->data_nascimento);
        }
        if (!empty($client->data_adesao)) {
            $arrCliente['data_adesao'] = $this->toDateBrasil($client->data_adesao);
        }

        return View('client_edit', ['client' => $arrCliente]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, client $client)
    {
        $this->validate($request, $this->rules);

        $data = $request->except('_token');
        if (!empty($data['data_nascimento'])) {
            $data['data_nascimento'] = $this->toDateBanco($data['data_nascimento']);
        }
        if (!empty($data['data_adesao'])) {
            $data['data_adesao'] = $this->toDateBanco($data['data_adesao']);
        }
        $client->update($data);
        return redirect('/clients');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(client $client)
    {
        //
    }

    public function addCalendar(Request $request)
    {
        $sendData = $request->except('_token');
        $data = explode('/', $sendData['data']);
        $data = $data[2] . '-' . $data[1] . '-' . $data[0];
        $sendData['data'] = $data;
        $sendData['valor'] = floatval($sendData['valor']);

        if(empty($sendData['calendar_id'])) {
            $calendar = Calendar::create($sendData);
            $calendar->refresh();
        } else {
            $calendar = Calendar::find($sendData['calendar_id']);
            $calendar->update($sendData);
        }

        return redirect('/clients?nome=' . urlencode($calendar->client->nome));
    }

    private function toDateBanco($data)
    {
        $data = explode('/', $data);
        $data = $data[2] . '-' . $data[1] . '-' . $data[0];
        return $data;
    }

    private function toDateBrasil($data)
    {
        $data = explode('-', $data);
        $data = substr($data[2], 0, 2) . '/' . $data[1] . '/' . $data[0];
        return $data;
    }

    public function calendarListBySeason($season)
    {
        $initialDate = '';
        $finalDate = '';
        switch ($season) {
            case 'daily':
                $initialDate = date('Y-m-d 00:00:00');
                $finalDate = date('Y-m-d 23:59:59');
                break;

            case 'weekly':
                $week = $this->getWeekly();
                $initialDate = $week[0];
                $finalDate = $week[1];
                break;

            case 'monthly':
                $initialDate = date('Y-m-01 00:00:00');
                $finalDate = date('Y-m-t 23:59:59');
        }

        // if (env('APP_ENV') === 'local') {
        //     $initialDate = '2021-06-01 00:00:00';
        //     $finalDate = '2021-06-10 23:59:00';
        // }

        $calendars = Calendar::whereBetween(DB::raw('DATE(data)'), [$initialDate, $finalDate])
            ->with('client')
            ->orderBy('data', 'desc')
            ->get();

        $traducao = '';
        switch ($season) {
            case 'daily':
                $traducao = 'do dia';
                break;
            case 'weekly':
                $traducao = 'da semana';
                break;
            case 'monthly':
                $traducao = 'do mês';
                break;
        }

        $key = 'valor';
        $sum = array_sum(array_column($calendars->toArray(), $key));

        $dataView = [
            'filtro' =>  $traducao,
            'results' => $calendars,
            'total' => $sum
        ];

        return view('rel_atendimentos_modal', ['dataView' => $dataView]);
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

        $week = ['dom' => '',
            'seg' => '',
            'ter' => '',
            'qua' => '',
            'qui' => '',
            'sex' => '',
            'sab' => ''];

        $keys = array_keys($week);

        if ($current > 0)
        {
            $now = strtotime('-'.($current).' day', $now);
        }

        for($i = 0; $i < 7; $i++)
        {
            $week[$keys[$i]] = date('d/m/Y', strtotime("+$i day", $now));
        }

        return [$week['dom'], $week['sab']];
    }
}
