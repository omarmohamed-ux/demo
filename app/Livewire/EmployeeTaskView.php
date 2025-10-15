<?php

namespace App\Livewire;
use App\Models\Category;
use App\Models\Task;
use Livewire\Component;

class EmployeeTaskView extends Component
{
   

    public function toggle_Task(Task $task)
    {
        // التأكد من أن المستخدم يملك المهمة 
        if ($task->user_id === auth()->id()) {
            $task->is_completed = !$task->is_completed;
            $task->save();
            
            // 2. لا تحتاج إلى أي شيء هنا.
            //    بمجرد انتهاء الدالة، Livewire سيستدعي render() تلقائياً.
        }
    }
    
    public function delete_Task(Task $task)
    {
        // للتأكد من حذف المهمة بشكل صحيح
        if ($task->user_id === auth()->id()) {
            $task->delete();
        }
    }

    public function render()
    {
        // 3. يتم جلب أحدث البيانات في كل مرة يتم فيها تحديث المكون
        $tasks = Task::with('Category')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
            
        // 4. نرسل $tasks إلى الواجهة
        return view('livewire.employee-task-view', compact( 'tasks'))
            ->layout('layouts.app');
    }
}