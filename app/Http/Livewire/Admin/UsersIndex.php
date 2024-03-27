<?php

namespace App\Http\Livewire\Admin;

use App\Models\Documento;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UsersIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $search;
    public $documento_id;
    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function toggleVigente($trabajadorId, $newValue)
    {
        $trabajador = User::findOrFail($trabajadorId);
        $trabajador->vigente = $newValue;
        $trabajador->save();
    }
    public function render()
    {
        $users = User::latest('id')
            ->where(function ($query) {
                $query->where('name', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('apellidos', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('numerodoc', 'LIKE', '%' . $this->search . '%');
            })
            ->when($this->documento_id, function ($query) {
                $query->where('documento_id', $this->documento_id);
            })            
            ->paginate(15);
        $documentos = Documento::all();    
        return view('livewire.admin.users-index', compact('users', 'documentos'));
    }
}
