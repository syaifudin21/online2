<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agenda;
use Calendar;
use Carbon\Carbon;

class AgendaController extends Controller
{
    public function index()
    {
        $events = [];
        $data   = Agenda::all();

        if($data->count())
        {
            foreach ($data as $key => $value)
            {

                $events[] = Calendar::event(
                    $value->title, false,  Carbon::createFromFormat('Y-m-d H:i:s', $value->start_date), Carbon::createFromFormat('Y-m-d H:i:s', $value->end_date), null,
                    ['color' => '#f05050', 'url' => url('admin')]
                );
            }
        }

        $calendar = Calendar::addEvents($events);
        return view('front.fullcalender', compact('calendar'));
    }
}
