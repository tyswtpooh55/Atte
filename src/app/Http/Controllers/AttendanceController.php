<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Work;
use App\Models\Breaking;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    // 日付別勤怠管理画面
    public function attendance(Request $request)
    {
        $thisDate = $request->date ? new Carbon($request->date) : Carbon::today();
        $prevDate = $thisDate->copy()->subDay();
        $nextDate = $thisDate->copy()->addDay();

        $thisDateAttendances = Work::whereDate('work_in', $thisDate)->paginate(5);

        $dateCalculationsHours = $this->dateCalculate($thisDateAttendances);

        $trueWorkHours = [];
        foreach ($thisDateAttendances as $thisDateAttendance) {
            $dateCalculationHours = $dateCalculationsHours[$thisDateAttendance->id];
            $trueWorkHours[$thisDateAttendance->id] = $dateCalculationHours['totalWorkHours'] - $dateCalculationHours['totalBreakingHours'];
        }

        return view('attendance', compact(
            'prevDate',
            'thisDate',
            'nextDate',
            'thisDateAttendances',
            'dateCalculationsHours',
            'trueWorkHours',
        ));
    }

    // 日付別勤務時間・休憩時間の計算式
    private function dateCalculate($attendances)
    {
        $dateCalculationsHours = [];

        foreach ($attendances as $attendance)
        {
            $totalWorkHours = 0;
            $totalBreakingHours = 0;

            $workIn = Carbon::parse($attendance->work_in);
            $workOut = Carbon::parse($attendance->work_out);
            $totalWorkHours += $workIn->diffInSeconds($workOut);

            $thisDateBreakings = Breaking::where('work_id', $attendance->id)->get();
            $totalBreakingHoursPerAttendance = 0;

            foreach ($thisDateBreakings as $thisDateBreaking) {
                $breakingIn = Carbon::parse($thisDateBreaking->breaking_in);
                $breakingOut = Carbon::parse($thisDateBreaking->breaking_out);
                $totalBreakingHoursPerAttendance += $breakingIn->diffInSeconds($breakingOut);
            }
            $totalBreakingHours += $totalBreakingHoursPerAttendance;

            $dateCalculationsHours[$attendance->id] = [
                'totalWorkHours' => $totalWorkHours,
                'totalBreakingHours' => $totalBreakingHours,
            ];
        }

        return $dateCalculationsHours;

    }
    //ユーザー一覧画面
    public function user()
    {
        $users = User::all();
        return view('user', compact('users'));
    }

    // ユーザー別勤務管理
    public function userAttendance($id)
    {
        $user = User::findOrFail($id);
        $userAttendances = $user->works;

        $userCalculationsHours = $this->userCalculate($userAttendances);

        $trueWorkHours = [];
        foreach ($userAttendances as $userAttendance) {
            $userCalculationHours = $userCalculationsHours[$userAttendance->id];
            $trueWorkHours[$userAttendance->id] = $userCalculationHours['totalWorkHours'] - $userCalculationHours['totalBreakingHours'];
        }

        return view('user_attendance', compact(
            'user',
            'userAttendances',
            'userCalculationsHours',
            'trueWorkHours',
        ));
    }

    // ユーザー別勤務時間・休憩時間の計算式
    private function userCalculate($userAttendances)
    {
        $userCalculationsHours = [];

        foreach ($userAttendances as $userAttendance) {
            $totalWorkHours = 0;
            $totalBreakingHours = 0;

            $workIn = Carbon::parse($userAttendance->work_in);
            $workOut = Carbon::parse($userAttendance->work_out);
            $totalWorkHours += $workIn->diffInSeconds($workOut);

            $userAttendanceBreakings = Breaking::where('work_id', $userAttendance->id)->get();
            $totalBreakingHoursPerAttendance = 0;

            foreach ($userAttendanceBreakings as $userAttendanceBreaking) {
                $breakingIn = Carbon::parse($userAttendanceBreaking->breaking_in);
                $breakingOut = Carbon::parse($userAttendanceBreaking->breaking_out);
                $totalBreakingHoursPerAttendance += $breakingIn->diffInSeconds($breakingOut);
            }
            $totalBreakingHours += $totalBreakingHoursPerAttendance;

            $userCalculationsHours[$userAttendance->id] = [
                'totalWorkHours' => $totalWorkHours,
                'totalBreakingHours' => $totalBreakingHours,
            ];
        }
        return $userCalculationsHours;
    }
}
