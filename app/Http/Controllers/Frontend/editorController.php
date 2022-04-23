<?php

namespace App\Http\Controllers\frontend;

use App\Enums\TableStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationStoreRequest;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class editorController extends Controller
{

    public function create(){

        $tables =Table::where('status' ,TableStatus::Available )->get();
        return view('editor.create' ,compact('tables'));
    }
    public function store(ReservationStoreRequest $request)
    {
        $table=Table::findOrFail($request->table_id);
        if($request->guest_number > $table->guest_number)
        {
            return back()->with('warning' , 'Please choose the table based on the desired guest number');
        }
        $request_date=Carbon::parse($request->res_date);
        foreach($table->reservations as $res)
        {
            if($res->res_date->format('Y-m-d')==$request_date->format('Y-m-d'))
            {
                return back()->with('warning' , 'Table is already reserved at this date , please choose another date');
            }
        }
        Reservation::create($request->validated());
        $reservations = Reservation::all();
        return to_route('dashboard' , compact('reservations'))->with('success' , 'Reservation added successfully');

    }
    public function edit($id)
    {
        $reservation = Reservation::find($id);
        $tables =Table::where('status' ,TableStatus::Available )->get();
        return view('editor.edit' , [
            'reservation'=>$reservation ,
            'tables'=>$tables
        ]);
    }
    public function destroy($id)
    {
        $reservation=Reservation::find($id);
        $reservation->delete();
        return to_route('dashboard')->with('warning', 'Reservation deleted successfully.');
    }
    public function update(ReservationStoreRequest $request, $id)
    {
        $reservation=Reservation::find($id);
        $table = Table::findOrFail($request->table_id);
        if ($request->guest_number > $table->guest_number) {
            return back()->with('warning', 'Please choose the table base on guests.');
        }
        $request_date = Carbon::parse($request->res_date);
       $reservations = $table->reservations()->where('id', '!=', $reservation->id)->get();
        foreach ($reservations as $res) {
            if ($res->res_date->format('Y-m-d') == $request_date->format('Y-m-d')) {
                return back()->with('warning', 'This table is reserved for this date.');
            }
        }

        $reservation->update($request->validated());
        return to_route('dashboard')->with('success', 'Reservation updated successfully.');
    }

}
