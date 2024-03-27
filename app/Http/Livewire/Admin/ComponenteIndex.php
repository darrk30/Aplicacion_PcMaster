<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Componente;
use App\Models\Marca;
use App\Models\Category;
use Livewire\WithPagination;

class ComponenteIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap";

    public $search;
    public $marca_id;
    public $categoria_id;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleVigente($componenteId, $newValue)
    {
        $componente = Componente::findOrFail($componenteId);
        $componente->vigente = $newValue;
        $componente->save();
    }

    public function render()
    {
        $marcas = Marca::all();
        $categorias = Category::all();

        $componentes = Componente::latest('id')
            ->where(function ($query) {
                $query->where('descripcion', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('codigo', 'LIKE', '%' . $this->search . '%');
            })
            ->when($this->marca_id, function ($query) {
                $query->where('marca_id', $this->marca_id);
            })
            ->when($this->categoria_id, function ($query) {
                $query->where('category_id', $this->categoria_id);
            })
            ->paginate(15);

        return view('livewire.admin.componente-index', compact('componentes', 'marcas', 'categorias'));
    }
}
