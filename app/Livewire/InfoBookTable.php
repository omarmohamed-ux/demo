<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Book; 
use App\Models\Author; 


class InfoBookTable extends Component
{

    // public $books;

   /* public function mount()
    {
        $this->books = Book::all();
    }*/
    
    public function render()
    {
        $books = Book::all();
        $authors = Author::all();

        return view('livewire.info-book-table', compact(['books','authors']))
        ->layout('layouts.app');
    }
}
