<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LeagueMatchController;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// 申し込みフォーム
Route::get('/entry', [EntryController::class, 'create'])->name('entry.create');
Route::post('/entry', [EntryController::class, 'store'])->name('entry.store');
Route::get('/admin/teams', [EntryController::class, 'index'])->name('entry.index');

// 管理者画面
Route::get('/admin/classes', [EntryController::class, 'classMenu']);
Route::get('/admin/classes/{class}', [EntryController::class, 'classList']);

Route::get('/admin/export/csv', [EntryController::class, 'exportCsv'])->name('admin.export.csv');

// グループ
Route::post('/groups/auto/{class}', [GroupController::class, 'auto'])->name('group.auto');
Route::get('/groups/{class}/edit', [GroupController::class, 'edit'])->name('group.edit');
Route::post('/team/move', [GroupController::class, 'move']);

// リーグ戦生成
Route::post('/groups/{group}/league/generate', [LeagueMatchController::class, 'generate'])->name('league.generate');

// リーグ戦表示
Route::get('/groups/{group}/league', [LeagueMatchController::class, 'index'])->name('league.index');

// リーグ戦集計
Route::get('/groups/{group}/league/standings', [LeagueMatchController::class, 'standings'])->name('league.standings');