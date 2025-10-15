<div>
    <div>
        <h1>update the equation</h1>
        <input type="number" wire:model="first_number">
        <input type="number" wire:model="second_number">
        <select wire:model.defer="operation">
        <option value="+">+</option>
        <option value="-">-</option>
        <option value="*"></option>
        <option value="/">/</option>
        </select>
        <button wire:click="updateCalulation">Update</button>
        <a href="/calulator">Back to Calulator</a>
    </div>
</div>
