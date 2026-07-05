<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class ProductManager extends Component
{
    use WithPagination, WithFileUploads;

    public string $search = '';
    public bool $showModal = false;
    public bool $isEditing = false;

    // Form fields
    public ?int $productId = null;
    public string $name = '';
    public string $sku = '';
    public ?string $barcode = '';
    public int $categoryId = 0;
    public float $price = 0;
    public int $stock = 0;
    public bool $isActive = true;
    public $image = null;
    public ?string $existingImage = null;

    protected function rules(): array
    {
        $skuRule = $this->isEditing
            ? "required|unique:products,sku,{$this->productId}"
            : 'required|unique:products,sku';

        $barcodeRule = $this->isEditing
            ? "nullable|unique:products,barcode,{$this->productId}"
            : 'nullable|unique:products,barcode';

        $rules = [
            'name' => 'required|string|max:255',
            'sku' => $skuRule,
            'barcode' => $barcodeRule,
            'categoryId' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'isActive' => 'boolean',
        ];

        if ($this->image) {
            $rules['image'] = 'image|max:2048';
        }

        return $rules;
    }

    public function openCreateModal(): void
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function openEditModal(int $id): void
    {
        $product = Product::findOrFail($id);
        $this->productId = $product->id;
        $this->name = $product->name;
        $this->sku = $product->sku;
        $this->barcode = $product->barcode ?? '';
        $this->categoryId = $product->category_id;
        $this->price = (float) $product->price;
        $this->stock = $product->stock;
        $this->isActive = $product->is_active;
        $this->existingImage = $product->image;
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'sku' => $this->sku,
            'barcode' => $this->barcode ?: null,
            'category_id' => $this->categoryId,
            'price' => $this->price,
            'stock' => $this->stock,
            'is_active' => $this->isActive,
        ];

        if ($this->image) {
            $filename = time() . '_' . Str::random(5) . '.' . $this->image->getClientOriginalExtension();
            $this->image->storeAs('', $filename, 'products');
            $data['image'] = $filename;

            if ($this->isEditing && $this->existingImage) {
                $oldPath = public_path('products/' . $this->existingImage);
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }
        }

        if ($this->isEditing) {
            Product::where('id', $this->productId)->update($data);
            $message = 'Produk berhasil diperbarui.';
        } else {
            Product::create($data);
            $message = 'Produk berhasil ditambahkan.';
        }

        $this->closeModal();
        $this->dispatch('notify', type: 'success', message: $message);
    }

    public function delete(int $id): void
    {
        $product = Product::find($id);
        if ($product) {
            $product->update(['is_active' => false]);
            $this->dispatch('notify', type: 'success', message: 'Produk berhasil dinonaktifkan.');
        }
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->reset(['productId', 'name', 'sku', 'barcode', 'categoryId', 'price', 'stock', 'isActive', 'image', 'existingImage']);
        $this->isActive = true;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $products = Product::with('category')
            ->when($this->search, function ($query) {
                $query->search($this->search);
            })
            ->orderBy('name')
            ->paginate(15);

        $categories = Category::active()->orderBy('name')->get();

        return view('livewire.product-manager', compact('products', 'categories'))
            ->layout('layouts.admin');
    }
}
