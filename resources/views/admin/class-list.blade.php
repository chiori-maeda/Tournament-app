@extends('layouts.app')
 
@section('title', 'team-list')
 
@section('content')
    <h2>{{ $class }}クラス一覧</h2>
    
    @foreach ($teams as $team)
    <div class="team-detail">
      <h4>{{ $team->team_name }}</h4>
      <p>代表者 : {{ $team->representative->name }}</p>
      <p>電話 : {{ $team->representative->phone }}</p>

      <strong>メンバー</strong>
      <ul>
        @foreach ($team->members as $member)
        <li>{{ $member->name }}</li>
            
        @endforeach
      </ul>
    </div>
        
    @endforeach
@endsection

<style>
  .team-detail {
    border:1px solid #ccc; 
    padding:10px; 
    margin:10px
  }


</style>
 