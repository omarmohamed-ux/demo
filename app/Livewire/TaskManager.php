<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Task;
use Livewire\Component;

class TaskManager extends Component
{
    public $category_name;
    public $category_id;
    public $title;


    
    public function save_category()
    {
        Category::create([
            'name' => $this->category_name,
        ]);
        $this->reset(['category_name']);
        session()->flash('message', 'تم إضافة نوع المهمه بنجاح!');
    }
    public function save_task()
    {
        Task::create([
            'category_id'=>$this->category_id,
            'user_id'=>auth()->user()->id,
            'title'=> $this->title,
            'is_completed'=>false
        ]);
        $this->reset(['title','category_id']);
        session()->flash('message', 'تم إضافة المهمه بنجاح!');
    }
    public function toggle_Task(Task $task)
    {
        // التأكد من أن المستخدم   
        if ($task->user_id === auth()->user()->id) {
            $task->is_completed = !$task->is_completed;//لو غير جاهزه خلها جاهزه و العكس
            $task->save();//حفظ التغيرات
        }
    }
    public function delete_Task(Task $task){

        if ($task->user_id === auth()->user()->id) {
        $task->delete();
        session()->flash('message','delete');

    }}

    public function render()
    {
        $categories = Category::all();
        $tasks = Task::with('Category')
            ->where('user_id', auth()->user()->id)
            ->latest()
            ->get();
            
        return view('livewire.task-manager', compact(['categories', 'tasks']))
            ->layout('layouts.app');
    }
}
