@extends('layouts.app')
 
@section('title', 'standings')
 
@section('content')
<h2>{{ $group->name }}順位表</h2>

<table class="table table-bordered">
  <tr>
    <th>順位</th>
    <th>チーム</th>
    <th>試</th>
    <th>勝</th>
    <th>分</th>
    <th>負</th>
    <th>得</th>
    <th>失</th>
    <th>差</th>
    <th>点</th>
  </tr>

  @foreach ($standings as $index => $standing)
      <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $standing['team']->team_name }}</td>
        <td>{{ $standing['played'] }}</td>
        <td>{{ $standing['win'] }}</td>
        <td>{{ $standing['draw'] }}</td>
        <td>{{ $standing['lose'] }}</td>
        <td>{{ $standing['goalsFor'] }}</td>
        <td>{{ $standing['goalsAgainst'] }}</td>
        {{-- <td>{{ $standing['goalDiff'] }}</td> --}}
        <td><strong>{{ $standing['points'] }}</strong></td>
      </tr>
      
  @endforeach
</table>
    
@endsection
 