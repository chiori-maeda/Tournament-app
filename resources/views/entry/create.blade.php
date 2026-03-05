@extends('layouts.app')
 
@section('title', 'entry')
 
@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
@endif

<form method="POST" action="{{ route('entry.store') }}">
  @csrf

  <h3>代表者</h3>
  <input type="text" name="representative_name" placeholder="代表者名">
  <input type="text" name="representative_address" placeholder="住所">
  <input type="tel" name="representative_phone" placeholder="電話番号">

  <hr>

  <div id="teams">
  {{-- チームブロックが入る --}}
  </div>

  <button type="button" onclick="addTeam()">+ チーム追加</button>

  <button type="submit">送信</button>
</form>
    
@endsection

<script>
let i = 0;

function addTeam() {
  const html = `
  <div class="team">
    <h4>チーム</h4>
    <input name="teams[${i}][team_name]" value="{{ old('teams.0.team_name') }}" placeholder="チーム名">

    <select name="teams[${i}][class]">
      <option value="" hidden>選択</option>
      <option value="男子A">男子A</option>
      <option value="男子B">男子B</option>
      <option value="男子C">男子C</option>
      <option value="女子AB">女子AB</option>
      <option value="女子C">女子C</option>
    </select>

    ${[1,2,3,4,5].map(n =>
      `<input name="teams[${i}][members][]" placeholder="メンバー${n}">`
    ).join("")}
  </div>`;

  document.getElementById('teams').insertAdjacentHTML('beforeend', html);
  i++;
}

addTeam(); // 初期1チーム
</script>
