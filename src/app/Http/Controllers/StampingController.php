<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Work;
use App\Models\Breaking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class StampingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $work = Work::where('user_id', $user->id)
            ->latest()
            ->first();

        if ($work) {
            $breaking = Breaking::where('work_id', $work->id)
                ->latest()
                ->first();
        }else{
            $breaking = null;
        }

        $workInBtnStatus =
            $work && empty($work->work_out);
        $workOutBtnStatus =
            !$work ||
            ($work && !empty($work->work_out)) ||
            ($breaking && empty($breaking->breaking_out));
        $breakingInBtnStatus =
            !$work ||
            ($work && !empty($work->work_out)) ||
            ($breaking && empty($breaking->breaking_out));
        $breakingOutBtnStatus =
            !$work ||
            ($work && !empty($work->work_out)) ||
            !$breaking ||
            ($breaking && !empty($breaking->breaking_out));

        return view('stamping', compact('user', 'workInBtnStatus', 'workOutBtnStatus', 'breakingInBtnStatus', 'breakingOutBtnStatus'));
    }

    // 勤務開始打刻
    public function workIn()
    {
        $user = Auth::user();
        Work::create([
            'user_id' => $user->id,
            'work_in' => Carbon::now(),
        ]);

        return redirect()->back();
    }

    // 勤務終了打刻
    public function workOut()
    {
        $user = Auth::user();
        $work = Work::where('user_id', $user->id)
            ->latest()
            ->first();
        $prevDayWork = Work::where('user_id', $user->id)
            ->whereDate('work_in', Carbon::today()->subDay())
            ->first();

        // 日付を跨いでいるときの処理
        if ($prevDayWork && is_null($prevDayWork->work_out)) {
            $prevDayWork->update([
                'work_out' => Carbon::yesterday()->endOfDay()
            ]);
            $work = Work::create([
                'user_id' => $user->id,
                'work_in' => Carbon::today()->startOfDay(),
                'work_out' => Carbon::now(),
            ]);
        }

        $work->update([
            'work_out' => Carbon::now()
        ]);

        return redirect()->back();
    }

    // 休憩開始打刻
    public function breakingIn()
    {
        $user = Auth::user();
        $work = Work::where('user_id', $user->id)
            ->latest()
            ->first();

        Breaking::create([
            'work_id' => $work->id,
            'breaking_in' => Carbon::now(),
        ]);

        return redirect()->back();
    }

    // 休憩終了打刻
    public function breakingOut()
    {
        $user = Auth::user();
        $work = Work::where('user_id', $user->id)
            ->latest()
            ->first();
        $breaking = Breaking::where('work_id', $work->id)
            ->latest()
            ->first();

        $prevDayWork = Work::where('user_id', $user->id)
            ->whereDate('work_in', Carbon::today()->subDay())
            ->first();

        $prevDayBreaking = Breaking::where('work_id', $work->id)
            ->whereDate('breaking_in', Carbon::today()->subDay())
            ->first();

        if ($prevDayBreaking && is_null($prevDayBreaking->breaking_out)) {
            $prevDayWork->update([
                'work_out' => Carbon::yesterday()->endOfDay()
            ]);
            $prevDayBreaking->update([
                'breaking_out' => Carbon::yesterday()->endOfDay()
            ]);

            $work = Work::create([
                'user_id' => $user->id,
                'work_in' => Carbon::today()->startOfDay()
            ]);
            $breaking = Breaking::create([
                'work_id' => $work->id,
                'breaking_in' => Carbon::today()->startOfDay(),
                'breaking_out' => Carbon::now(),
            ]);


        }

        $breaking->update([
            'breaking_out' => Carbon::now(),
        ]);

        return redirect()->back();
    }
}
