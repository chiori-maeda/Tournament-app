@extends('layouts.app')
 
@section('title', 'class-menu')
 
@section('content')
    
<h2>クラス一覧</h2>
@foreach ($classes as $class)

  <div class="mb-3">

    <h4>{{ $class }}</h4>

    {{-- 一覧 --}}
    <a href="{{ route('group.edit',$class) }}" class="btn btn-outline-primary">
        パート調整
    </a>

    {{-- 自動グループ分け --}}
    <form method="POST" action="{{ route('group.auto',$class) }}" style="display:inline">
        @csrf
        <button class="btn btn-success">
            自動パート分け
        </button>
    </form>

  </div>

@endforeach


  {{-- CSV出力ボタン --}}
    <a href="{{ route('admin.export.csv') }}" class="btn btn-success">CSV出力</a>
    <br>

@foreach ($classes as $class)
  <div class="">
    <a href="/admin/classes/{{ $class }}">{{ $class }}</a>
  </div>
    
@endforeach
@endsection
 