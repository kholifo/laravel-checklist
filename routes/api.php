<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/v1')->group(function () {
    Route::post('checklists', 'API\ChecklistController@store');
    Route::post('checklists/{checklist_id}/items', 'API\ChecklistController@storeLists');

    Route::get('checklists', 'API\ChecklistController@show');
    Route::get('checklists/{checklist_id}', 'API\ChecklistController@getChecklistById');

    Route::patch('checklists/{checklist_id}', 'API\ChecklistController@checklistUpdate');
    Route::patch('checklists/{checklist_id}/items/{item_id}', 'API\ChecklistController@itemUpdate');

    Route::delete('checklists/{checklist_id}', 'API\ChecklistController@checklistDestroy');
    Route::delete('checklists/{checklist_id}/items/{item_id}', 'API\ChecklistController@checklistItemDestroy');
});
