<?php

namespace App\Livewire;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserManager extends Component
{
    use WithPagination;

    public string $search = '';
    public bool $showModal = false;
    public bool $isEditing = false;

    // Form fields
    public ?int $userId = null;
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public int $roleId = 0;
    public bool $isActive = true;

    protected function rules(): array
    {
        $emailRule = $this->isEditing
            ? "required|email|unique:users,email,{$this->userId}"
            : 'required|email|unique:users,email';

        $passwordRule = $this->isEditing
            ? 'nullable|string|min:6'
            : 'required|string|min:6';

        return [
            'name' => 'required|string|max:255',
            'email' => $emailRule,
            'password' => $passwordRule,
            'roleId' => 'required|exists:roles,id',
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
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->roleId = $user->role_id;
        $this->isActive = $user->is_active;
        $this->password = ''; // reset password input
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role_id' => $this->roleId,
            'is_active' => $this->isActive,
        ];

        if ($this->password) {
            $data['password'] = bcrypt($this->password);
        }

        if ($this->isEditing) {
            User::where('id', $this->userId)->update($data);
            $message = 'User berhasil diperbarui.';
        } else {
            if (empty($data['password'])) {
                $data['password'] = bcrypt('password'); // fallback
            }
            User::create($data);
            $message = 'User berhasil ditambahkan.';
        }

        $this->closeModal();
        $this->dispatch('notify', type: 'success', message: $message);
    }

    public function delete(int $id): void
    {
        // Don't allow self-deletion
        if ($id === auth()->id()) {
            $this->dispatch('notify', type: 'error', message: 'Anda tidak dapat menghapus diri sendiri.');
            return;
        }

        $user = User::find($id);
        if ($user) {
            $user->update(['is_active' => false]);
            $this->dispatch('notify', type: 'success', message: 'User berhasil dinonaktifkan.');
        }
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->reset(['userId', 'name', 'email', 'password', 'roleId', 'isActive']);
        $this->isActive = true;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $users = User::with('role')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                      ->orWhere('email', 'like', "%{$this->search}%");
            })
            ->paginate(15);

        $roles = Role::all();

        return view('livewire.user-manager', compact('users', 'roles'))
            ->layout('layouts.admin');
    }
}
