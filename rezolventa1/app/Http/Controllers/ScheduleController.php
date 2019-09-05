<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ScheduleController extends Controller
{

    /*
     * Является ли выбранный день отпуском
     */
    private static function IsVacation($oCurrent, $aVacationList){
        $r = false;
        foreach($aVacationList as $vacation){
            $from = Carbon::parse($vacation['from'] . '.' . $oCurrent->year);
            $to = Carbon::parse($vacation['to'] . '.' . $oCurrent->year);
            if($oCurrent->greaterThanOrEqualTo($from) && $oCurrent->lessThanOrEqualTo($from)){
                $r = true;
                break;
            }
        }
        return $r;
    }


    /*
     * Получает список рабочих интервалов в заданный день, исключая корпоратив
     */
    private static function UseCorporateParty($oCurrent, $aTimeRanges){
        $oCorporateFrom = Carbon::parse('10.01.2018 15:00');
        $oCorporateTo = Carbon::parse('11.01.2018 00:00');
        
        $r = [];

        foreach($aTimeRanges as $range){
            $start = Carbon::createFromFormat('YmdHi', $oCurrent->format('Ymd').$range['start']);
            $end = Carbon::createFromFormat('YmdHi', $oCurrent->format('Ymd').$range['end']);
            
            if($oCorporateTo->lessThanOrEqualTo($start) || $oCorporateFrom->greaterThanOrEqualTo($end)){
                $r[] = $range;
            }

            if($oCorporateFrom->greaterThan($start) && $oCorporateFrom->lessThan($end)){
                $tmp = ['start' => $range['start'], 'end' => $oCorporateFrom->format('Hi')];
                $r[] = $tmp;
            }
            if($oCorporateTo->greaterThan($start) && $oCorporateTo->lessThan($end)){
                $tmp = ['start' => $oCorporateTo->format('Hi'), 'end' => $range['end']];
                $r[] = $tmp;
            }
        }

        return $r;
    }
    


    /*
     * Получает список праздников
     */
    private static function GetCalendar(){
        $r = collect();
        $fgc = file_get_contents('https://www.googleapis.com/calendar/v3/calendars/ru.russian%23holiday%40group.v.calendar.google.com/events?key=AIzaSyC9E0hOazoUe2wCawB5YWCav3TFmlptnbs');
        $x = json_decode($fgc);
        foreach($x->items as $event){
            $r[] = $event->start->date;
        }
        return $r;
    }

    /*
     * Является ли выбранный день праздником
     */
    private static function IsHoliday($oCurrent, $oCalendar){
        $r = $oCalendar->contains($oCurrent->format('Y-m-d'));
        return $r;
    }


    public function schedule(Request $request)
    {
        $aUserList = [
            1 => [
                'vacation' => [
                    ['from' => '11.01', 'to' => '25.01'],
                    ['from' => '01.02', 'to' => '15.02']
                ],
                'timeRanges'=> [                 
                    ['start'=> '1000', 'end'=> '1300'],                 
                    ['start'=> '1400', 'end'=> '1900']             
                ]
            ],
            2 => [
                'vacation' => [
                    ['from' => '01.02', 'to' => '01.03'],
                ],
                'timeRanges'=> [                 
                    ['start'=> '0900', 'end'=> '1200'],                 
                    ['start'=> '1300', 'end'=> '1800']             
                ]
            ]
        ];

        $r = (object)['schedule' => []];

        $tmp = $request->input('startDate');
        $oStartDate = Carbon::parse($tmp);

        $tmp = $request->input('endDate');
        $oEndDate = Carbon::parse($tmp);

        $iUserId = $request->input('userId');

        $aUserProfile = $aUserList[$iUserId];

        if($oStartDate->greaterThan($oEndDate)){
            throw new \Exception('Конечная дата больше начальной');
        }

        $oCurrent = clone $oStartDate;

        $oCalendar = self::GetCalendar();

        while($oCurrent->lessThanOrEqualTo($oEndDate)){
            $aCorporatePartyRemainder = self::UseCorporateParty($oCurrent, $aUserProfile['timeRanges']);

            $bNotWork = $oCurrent->isWeekend() ||
            self::IsVacation($oCurrent, $aUserProfile['vacation']) || 
            !count($aCorporatePartyRemainder) ||
            self::IsHoliday($oCurrent, $oCalendar);

            $bInclude = !$bNotWork;

            if($bInclude){
                $r->schedule[] = (object)[
                    'day' => $oCurrent->format('Y-m-d'), 
                    'timeRanges' => $aCorporatePartyRemainder
                ];
                
            }

            $oCurrent->addDay();
        }


        return response()->json($r);
        
    }



}
