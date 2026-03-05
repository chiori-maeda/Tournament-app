@extends('layouts.app')
 
@section('title', 'Group Edit')
 
@section('content')
    

<h2>{{ $class }} パート調整</h2>
<div class="row">
  
  @foreach ($groups as $group)
  <div class="col-md-3">
    <h4>{{ $group->name }}</h4>
    
    <div class="group-box" data-group-id="{{ $group->id }}">
      @foreach ($group->teams as $team)
      <div class="team-card" data-team-id="{{ $team->id }}">
        {{ $team->team_name }}
      </div>
      @endforeach
    </div>
  </div>
  
  <form  method="post" action="{{ route('league.generate', $group->id) }}">
    @csrf
    <button class="brn brn-sm brn-warning">
      リーグ生成
    </button>
  </form>
  @endforeach
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    

<script>

  document.addEventListener("DOMContentLoaded", function() {

    document.querySelectorAll('.group-box').forEach(box => {
      new Sortable(box, {
        group: 'shared',
        animation: 150,
        
        onEnd: function (evt) {
          let teamId = evt.item.dataset.teamId;
          let newGroupId = evt.to.dataset.groupId;
          
          fetch("/team/move", {
            method:"POST",
            headers: {
              "Content-Type":"application/json",
              "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
              team_id: teamId,
              group_id: newGroupId
            })
          });
        }
      });
    });
  });
  </script>


@endsection