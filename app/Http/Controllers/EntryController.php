<?php

namespace App\Http\Controllers;

use App\Models\Representative;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\group;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EntryController extends Controller
{

    public function create() {
       return view('entry.create');
    }

    public function store(Request $request) { 
        // バリデーション
        $request->validate([
            'representative_name'       => 'required|string|max:50',
            'representative_address'    => 'required|string|max:255',
            'representative_phone'      => 'required|string|max:20',

            'teams'                     => 'required|array|min:1',
            'teams.*.team_name'         => 'required|string|max:50',
            'teams.*.class'             => 'required|string',

            'teams.*.members'           => 'required|array|min:3',
            'teams.*.members.*'         => 'nullable|string|max:50',
        ],
        [
            // エラーメッセージ
            'representative_name.required'   => '代表者名は必須です',
            'representative_address.required'=> '住所は必須です',
            'representative_phone.required'  => '電話番号は必須です',

            'teams.required'                 => 'チームを１つ以上入力してください',
            'teams.*.team_name.required'     => 'チーム名は必須です',
            'teams.*.class.required'         => 'クラスを選択してください',

            'teams.*.members.min'            => 'メンバーは３人以上必要です',
        ]);

        foreach ($request->teams as $i => $team) {
            
            $members = array_filter($team['members']);

            if (count($members) < 3) {
                return back()
                    ->withErrors(["teams.$i.members" => "メンバーは３人以上入力してください"])
                    ->withInput();
            }
        }

        // 保存処理
        $rep = Representative::create([
            'name'      => $request->representative_name,
            'address'   => $request->representative_address,
            'phone'     => $request->representative_phone,
        ]);

        foreach ($request->teams as $teamData) {
            $team = $rep->teams()->create([
                'team_name'     => $teamData['team_name'],
                'class'         => $teamData['class'],
            ]);

            foreach ($teamData['members'] as $name) {
                $name = trim($name);
                if ($name !=='') {
                    $team->members()->create([
                        'name'      => $name
                    ]);
                }
            }

        
        }

        return "申し込み完了しました";
       
    }

    public function index() {
       $teams = Team::with('members', 'representative')->get();
       return view('admin.teams', compact('teams'));
    }

    public function classMenu() {
       $classes = Team::select('class')
            ->distinct()
            ->orderBy('class')
            ->pluck('class');

        return view('admin.class-menu', compact('classes'));
    }
    

    public function classList($class) {
       $teams = Team::with('members','representative')
            ->where('class', $class)
            ->orderBy('team_name')
            ->get();
        
            return view('admin.class-list', compact('teams','class'));
    }

    // CSV出力
    public function exportCsv(){
       $teams = Team::with('members','representative')->get();

       $response = new StreamedResponse(function() use ($teams) {
            $handle = fopen ('php://output', 'w');

            // Excelでの文字化け防止
            fputs($handle, "\xEF\xBB\xBF");

            // ヘッダー行
            fputcsv($handle, [
                'クラス',
                'チーム名',
                '代表者名',
                '電話番号',
                'メンバー1',
                'メンバー2',
                'メンバー3',
                'メンバー4',
                'メンバー5',
            ]);

            foreach ($teams as $team) {
                $members = $team->members->pluck('name')->toArray();

                $members = array_pad($members, 5, '');

                fputcsv($handle,[
                    $team->class,
                    $team->team_name,
                    $team->representative->name ?? '',
                    $team->representative->phone ?? '',
                    $members[0],
                    $members[1],
                    $members[2],
                    $members[3],
                    $members[4],
                ]);
            }
            fclose($handle);
        });    
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set(
            'Content-Disposition',
            'attachment; filename="teams.csv"'
        );

        return $response;
    }

    

}
