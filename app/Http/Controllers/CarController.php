<?php

namespace App\Http\Controllers;

use App\Http\Resources\CarResource;
use App\Models\Car;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
    
    public function findCar (Request $request)
    {
        $cars = Car::all();

        $user = Auth::user();
        $maxComfortLvl = $user->position->max_comfort_lvl;
        $cars = $cars->where('comfort_level', '<=', $maxComfortLvl);

        if (isset($request->datetime_start) && isset($request->datetime_end)) {
            $datetimeStart = intval($request->datetime_start);
            $datetimeEnd = intval($request->datetime_end);
        }else{
            return ['Error' => 'Datetime keys are missing'];
        }

        if (isset($request->model)) {
            $requestModel = $request->model;
            $cars = $cars->where('model_id', '=',$requestModel);
        }

        if (isset($request->comfort_level)) {
            $requestComfortLevel = intval($request->comfort_level);
            $cars = $cars->where('comfort_level', '=', $requestComfortLevel);
        }

        return $this->getVacantCars($cars, $datetimeStart, $datetimeEnd);

    }

    private function getVacantCars ($cars, $datetimeStart, $datetimeEnd)
    {

        foreach ($cars as $car) {

            if (!$this->isVacant($car, $datetimeStart, $datetimeEnd)) {
                $cars->forget($car);
            }
        }

        return CarResource::collection($cars);
    }

    private function isVacant($car, $datetimeStart, $datetimeEnd)
    {
        $events = $car->events()->get();

        $tz = 'Europe/Moscow';
        $datetimeStart = new Carbon($datetimeStart, $tz);
        $datetimeEnd = new Carbon($datetimeEnd, $tz);

        $timeDelta = $datetimeStart->diffInHours($datetimeEnd);

        foreach ($events as $event) {
            
            $eventStart = new Carbon($event->event_start, $tz);
            $eventEnd = new Carbon($event->event_end, $tz);

            for ($timeCounter = 0; $timeCounter < $timeDelta; $timeCounter++) {
                $stepTime = $datetimeStart->addHours($timeCounter);

                if ($stepTime->isBetween($eventStart, $eventEnd)) {
                    return false;
                }
            }
        }

        return True;
    }
}
