<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\LeagueMatch;
use App\Models\Team;

class GroupController extends Controller
{
    // グループ分け
    public function auto($class) {
       $teams = Team::where('class', $class)
            ->with('representative')
            ->get()
            ->shuffle();

        if($teams->isEmpty()) {
            return back()->with('error','チームがありません');
        }

        // 先に group_id を外す
        Team::where('class', $class)->update([
        'group_id' => null
        ]);

        // 既存のパート削除
        Group::where('class', $class)->delete();
        
        // パート数を自動決定
        $teamCount = $teams->count();

        // １パート３〜５チーム想定→４で割る
        $groupCount = ceil($teamCount / 4);

        

        // パート自動生成
        $groups = collect();
        for ($i = 1; $i <= $groupCount; $i++) {
            $groups->push(
                Group::create([
                    'class' =>$class,
                    // Aパート、Bパート...とする
                    'name' => chr(64 + $i) .'パート'
                ])
            );
        }


        // 代表者ごとにまとめる
        $byRep = $teams->groupBy('representative_id');
        $index = 0;

        foreach ($byRep as $repTeams) {
            foreach ($repTeams as $team) {
                $group = $groups[$index % $groupCount];
                $team->update([
                    'group_id' =>$group->id
                ]);
                $index++;
            }
        }

        return back()->with('ok','自動振り分け完了');
    }

    // 編集
    public function edit($class) {
        $groups = Group::with('teams.members')
            ->where('class',$class)
            ->get();
        return view('admin.group-edit',compact('groups','class'));
       
    }

    // 移動保存API
    public function move(Request $request) {
       Team::where('id', $request->team_id)
        ->update([
            'group_id' => $request->group_id
        ]);

        return response()->json(['ok' => true]);
    }

    // リーグ戦の試合組み合わせ
    public function leagueMatchs() {
       return $this -> hasMany(LeagueMatch::class);
    }

}
