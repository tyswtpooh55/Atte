@extends('layouts/app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('header')
    <div class="header__link">
        <form action="/" method="GET">
            @csrf
            <button class="header__link--btn" type="submit" name="home">ホーム</button>
        </form>
        <form action="/attendance" method="GET">
            @csrf
            <button class="header__link--btn" type="submit" name="date">日付一覧</button>
        </form>
        <form action="/user" method="GET">
            @csrf
            <button class="header__link--btn" type="submit" name="user">ユーザー一覧</button>
        </form>
        <form action="/logout" method="POST">
            @csrf
            <button class="header__link--btn" type="submit" name="logout">ログアウト</button>
        </form>
    </div>
@endsection

@section('content')
    <div class="atte__content">
        <h2 class="atte-date content__heading">
            <a href="{{ route('attendance', ['date' => $prevDate->toDateString()]) }}" class="date_change">&lt;</a>
            {{ $thisDate->format('Y-m-d') }}
            <a href="{{ route('attendance', ['date' => $nextDate->toDateString()]) }}" class="date_change">&gt;</a>
        </h2>
        <div class="atte-box">
            <table class="atte__table">
                <tr class="atte__row">
                    <th class="atte__label">名前</th>
                    <th class="atte__label">勤務開始</th>
                    <th class="atte__label">勤務終了</th>
                    <th class="atte__label">休憩時間</th>
                    <th class="atte__label">勤務時間</th>
                </tr>
                @foreach ($thisDateAttendances as $thisDateAttendance)
                    @if ($thisDateAttendance->work_out)
                        <tr class="atte__row">
                            <td class="atte__data">{{ $thisDateAttendance->user->name }}</td>
                            <td class="atte__data">{{ \Carbon\Carbon::parse($thisDateAttendance->work_in)->format('H:i:s') }}</td>
                            <td class="atte__data">{{ \Carbon\Carbon::parse($thisDateAttendance->work_out)->format('H:i:s') }}</td>
                            <td class="atte__data">{{ \Carbon\CarbonInterval::seconds($dateCalculationsHours[$thisDateAttendance->id]['totalBreakingHours'])->cascade()->format('%H:%I:%S') }}</td>
                            <td class="atte__data">{{ \Carbon\CarbonInterval::seconds($trueWorkHours[$thisDateAttendance->id])->cascade()->format('%H:%I:%S') }}</td>
                        </tr>
                    @endif
                @endforeach
                </table>
                {{ $thisDateAttendances->links('vendor.pagination.custom') }}
        </div>
    </div>
@endsection