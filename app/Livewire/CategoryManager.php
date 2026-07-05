<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class CategoryManager extends Component
{
    use WithPagination;

    public string $search = '';
    public bool $showModal = false;
    public bool $isEditing = false;

    // Form fields
    public ?int $categoryId = null;
    public string $name = '';
    public bool $isActive = true;

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'isActive' => 'boolean',
        ];
    }

    public function openCreateModal(): void
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function openEditModal(int $id): void
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->isActive = $category->is_active;
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'is_active' => $this->isActive,
        ];

        if ($this->isEditing) {
            Category::where('id', $this->categoryId)->update($data);
            $message = 'Kategori berhasil diperbarui.';
        } else {
            Category::create($data);
            $message = 'Kategori berhasil ditambahkan.';
        }

        $this->closeModal();
        $this->dispatch('notify', type: 'success', message: $message);
    }

    public function delete(int $id): void
    {
        $category = Category::find($id);
        if ($category) {
            $category->update(['is_active' => false]);
            $this->dispatch('notify', type: 'success', message: 'Kategori berhasil dinonaktifkan.');
        }
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->reset(['categoryId', 'name', 'isActive']);
        $this->isActive = true;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $categories = Category::when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%");
            })
            ->orderBy('name')
            ->paginate(15);

        return view('livewire.category-manager', compact('categories'))
            ->layout('layouts.admin');
    }
}
