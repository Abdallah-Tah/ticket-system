<?php

namespace App\Livewire\Categories;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;

class CategoryComponent extends Component
{
    use WithPagination;

    public $categoryId;
    public $name;
    public string $sortColumn = 'created_at';
    public string $sortDirection = 'desc';
    public $sortBy;
    public $sortAsc = true;
    public $search = '';
    public $perPage = 10;
    public $showModal = false;
    public $deleteModal = false;
    public $error_string = '';

    protected $rules = [
        'name' => 'required|min:3',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updating($name)
    {
        $this->resetPage();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function sortByColumn($column)
    {
        if ($this->sortColumn === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortColumn = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        $categories = Category::where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->perPage);
        return view('livewire.categories.category-component', ['categories' => $categories]);
    }

    public function openModal()
    {
        $this->resetInput();
        $this->showModal = true;
    }

    public function createCategory()
    {
        $this->validate();
        Category::create(['name' => $this->name]);
        $this->showModal = false;
        $this->resetInput();
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $id;
        $this->name = $category->name;
        $this->showModal = true;
    }

    public function updateCategory()
    {
        $this->validate();
        $category = Category::findOrFail($this->categoryId);
        $category->update(['name' => $this->name]);
        $this->showModal = false;
        $this->resetInput();
    }

    public function showDeleteModal($id)
    {
        $this->categoryId = $id;
        $this->name = Category::findOrFail($id)->name;
        $this->deleteModal = true;
    }

    public function deleteCategory()
    {
        Category::destroy($this->categoryId);
        $this->deleteModal = false;
    }

    private function resetInput()
    {
        $this->categoryId = null;
        $this->name = '';
    }
}
