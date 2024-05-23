<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/show/{id}', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/changePassword', [ProfileController::class, 'changePassword'])->name('profile.changePassword');

    //Employee
    Route::get('/', [EmployeeController::class, 'index'])->name('employee');
    Route::post('/employee/getData', [EmployeeController::class, 'getData'])->name('employee.getData');
    Route::post('/employee/store', [EmployeeController::class, 'store'])->name('employee.store');
    Route::get('/employee/show/{id}', [EmployeeController::class, 'show'])->name('employee.show');
    Route::post('/employee/update', [EmployeeController::class, 'update'])->name('employee.update');
    Route::post('/employee/delete/{id}', [EmployeeController::class, 'destroy'])->name('employee.delete');
});

require __DIR__ . '/auth.php';
