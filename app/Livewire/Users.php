<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination, WithoutUrlPagination;

    public function render()
    {
        $users = User::paginate(10);
        return view('livewire.users', ['users' => $users]);
    }
public function updatedPage($page)
{
    $this->js('initFlowbite();');
}
}
