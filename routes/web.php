<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Livewire\Tickets\TicketComponent;
use App\Livewire\Statuses\StatusComponent;
use App\Http\Controllers\ProfileController;
use App\Livewire\Departments\DepartmentComponent;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');

    Route::get('users', [UserController::class, 'index'])->name('users.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/tickets', TicketComponent::class)->name('tickets.index');
    Route::get('/departments', DepartmentComponent::class)->name('departments.index');
    Route::get('/categories', App\Livewire\Categories\CategoryComponent::class)->name('categories.index');
    Route::get('/plans', App\Livewire\Plans\PlanComponent::class)->name('plans.index');
    Route::get('/priorities', App\Livewire\Priorities\PriorityComponent::class)->name('priorities.index');
    Route::get('/statuses', StatusComponent::class)->name('statuses.index');
    Route::get('/tickets/{ticket}', App\Livewire\Tickets\ViewTicketComponent::class)->name('tickets.show');
});

require __DIR__ . '/auth.php';
