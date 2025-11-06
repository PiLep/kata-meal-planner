<?php

namespace App\Livewire\Home;

use Domain\MealPlanning\Actions\GetDailyMeals;
use Livewire\Attributes\Layout;
use Livewire\Component;

class DailyDigest extends Component
{
    public $meals;

    public $currentDate;

    public function mount(): void
    {
        $this->currentDate = now()->toDateString();
        $this->loadMeals();
    }

    public function loadMeals(): void
    {
        $action = new GetDailyMeals;
        $this->meals = $action->execute(auth()->id(), $this->currentDate);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.home.daily-digest');
    }
}
