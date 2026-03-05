@extends('layouts.app')
 
@section('title', 'league')
 
@section('content')
    

<h2>{{ $group->name }}  リーグ表</h2>

<table class="table">
  <tr>
    <th>対戦</th>
  </tr>
  @foreach ($matches as $match)
      <tr>
        <td>
          {{ $match->team1->team_name }}
          vs
          {{ $match->team2->team_name }}
        </td>
      </tr>
  @endforeach
</table>
@endsection
 