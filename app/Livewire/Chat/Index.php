<?php

namespace App\Livewire\Chat;
use App\Models\Conversation;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.chat.index')->layout('layouts.app');
    }
}
