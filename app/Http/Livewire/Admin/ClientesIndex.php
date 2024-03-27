<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Cliente;
use App\Models\Documento;
use Livewire\WithPagination;

class ClientesIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $search;
    public $documento_id;
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleVigente($componenteId, $newValue)
    {
        $componente = Cliente::findOrFail($componenteId);
        $componente->vigente = $newValue;
        $componente->save();
    }
    public function render()
    {
        $documentos = Documento::all();
        $clientes = Cliente::latest('id')
            ->where(function ($query) {
                $query->where('nombres', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('numerodoc', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('apellidos', 'LIKE', '%' . $this->search . '%');
            })
            ->when($this->documento_id, function ($query) {
                $query->where('documento_id', $this->documento_id);
            })            
            ->paginate(15);
        return view('livewire.admin.clientes-index', compact('documentos', 'clientes'));
    }
}
