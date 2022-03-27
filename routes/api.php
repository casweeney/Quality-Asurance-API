<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\QaController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/user/signup', [AuthController::class, 'signupStore'])->name('signupStore');
Route::post('/user/signin', [AuthController::class, 'login'])->name('login');
Route::post('/submit/project', [QaController::class, 'submitProject'])->middleware('jwt.auth');
Route::get('/user/fetch/projects', [QaController::class, 'fetchUserProjects'])->middleware('jwt.auth');
Route::get('/fetch/all/projects', [QaController::class, 'fetchAllProjects'])->middleware('jwt.auth');
Route::get('/fetch/project/{id}/details', [QaController::class, 'fetchProjectDetails'])->middleware('jwt.auth');
Route::post('/submit/qa', [QaController::class, 'submitQa'])->middleware('jwt.auth');
Route::put('/add/dev/qa/{qaID}/comment', [QaController::class, 'addDevComment'])->middleware('jwt.auth');
Route::put('/update/project/{projectID}/status', [QaController::class, 'updateProjectStatus'])->middleware('jwt.auth');

Route::get('/projects', [TestController::class, 'index']);
Route::post('/projects', [TestController::class, 'store']);
Route::get('/projects/{projectID}', [TestController::class, 'show']);
Route::put('/projects/{projectID}', [TestController::class, 'update']);
Route::delete('/projects/{projectID}', [TestController::class, 'destroy']);

Route::resource('projects', TestController::class);


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

});