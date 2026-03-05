<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\LeagueMatch;


class LeagueMatchController extends Controller
{
    public function generate($groupId) {
       $group = Group::with('teams')->findOrFail($groupId);
       $teams = $group->teams->values();

        // 既存削除
        LeagueMatch::where('group_id',$groupId)->delete();

        for($i=0; $i < $teams->count(); $i++) {
            for ($j=$i+1; $j < $teams->count(); $j++) { 

                LeagueMatch::create([
                    'group_id' =>$groupId,
                    'team1_id' => $teams[$i]->id,
                    'team2_id' => $teams[$j]->id
                ]);
            }
        }
        return back()->with('ok','リーグ戦生成完了');
    }

    // リーグ戦表示
    public function index($groupId) {
        $group = Group::findOrFail($groupId);
         $matches = LeagueMatch::with(['team1','team2'])->where('group_id',$groupId)->get();
         return view('admin.league', compact('matches','group'));
    }

    // リーグ集計ロジック
    public function standings($groupId) {
       $group = Group::with(['teams','leagueMatches'])->findOrFail($groupId);

       $standings = collect();
       foreach ($group->teams as $team) {
            $played = 0;
            $win = 0;
            $draw = 0;
            $lose = 0;
            $goalsFor = 0;
            $goalsAgainst = 0;
            $points = 0;

            foreach ($group->leagueMatches as $match) {
                if ($match->team1_id == $team->id || $match->team2_id == $team->id) {
                    $played++;

                    if ($match->team1_score !== null && $match->team2_score !== null) {
                        if ($match->team1_id == $team->id) {
                            $goalsFor += $match->team1_score;
                            $goalsAgainst += $match->team2_score;

                            if ($match->team1_score > $match->team2_score) {
                                $win++;
                                $points += 3;
                            } elseif ($match->team1_score == $match->team2_score) {
                                $draw++;
                                $points += 1;
                            } else {
                                $lose++;
                            }
                        } else {
                            $goalsFor += $match->team2_score;
                            $goalsAgainst += $match->team1_score;

                            if ($match->team2_score > $match->team1_score) {
                                $win++;
                                $points += 3;
                            } elseif ($match->team2_score == $match->team1_score) {
                                $draw++;
                                $points += 1;
                            } else {
                                $lose++;
                            }
                        }
                    }
                }
            } 

            $standings->push([
                'team' => $team,
                'played' => $played,
                'win' => $win,
                'draw' => $draw,
                'lose' => $lose,
                'goalsFor' => $goalsFor,
                'goalsAgainst' => $goalsAgainst,
                'points' => $points
            ]);
       }

       $standings = $standings->sortByDesc('points')
            ->sortByDesc('goalsFor')
            ->sortBy('goalsAgainst')
            ->values();
       
       return view('admin.standings', compact('group','standings'));
    }
}


