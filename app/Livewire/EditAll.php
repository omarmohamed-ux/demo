<?php

namespace App\Livewire;

use Livewire\Component;
use App\Livewire\ViewBookDetails; 

use App\Models\BookType ;//استدعاء مودل من قاعده البيانات محتاجه شرح***
use App\Models\Book; 
use App\Models\Author;

class EditAll extends Component
{
    public $name;
    public $author_id;
    public $book_type_id;
    public $publication_year;
    public $type;
    public $bookId;

    
    public $bookTypes ; // تعريف خاصية عامة لتخزين أنواع الكتب
    public $books; 
    public $authors; 

    public function mount($bookId)
{
    $this->bookTypes = BookType::all();
    $this->books = Book::all();
    $this->authors = Author::all();

    $book = Book::findOrFail($bookId);

    $this->bookId = $bookId;
    $this->name = $book->name;
    $this->author_id = $book->author_id;
    $this->book_type_id = $book->book_type_id;
    $this->publication_year = $book->publication_year;
}


    public function updateBook(){
        //dump('name','author_id','book_type_id','publication_year');
        $books = Book::findOrFail($this->bookId); 
        $books->update([ 
            'name' => $this->name,
            'author_id' => $this->author_id,
            'book_type_id' => $this->book_type_id,
            'publication_year' => $this->publication_year,
        ]);
        
        session()->flash('message', 'تم تعديل الكتاب بنجاح!');
        $this->reset(['name', 'book_type_id', 'publication_year']);
        return redirect()->route('books.view');



    }

    public function render()
    {   
        $bookTypes = BookType::all(); 
        $books = Book::all();
        $authors = Author::all();
        return view('livewire.edit-all', compact(['bookTypes', 'books','authors']))
            ->layout('layouts.app');
    }
}
