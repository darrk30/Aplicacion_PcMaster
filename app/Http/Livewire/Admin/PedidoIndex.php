<?php

namespace App\Http\Livewire\Admin;

use App\Models\Pedido;
use Livewire\Component;
use Livewire\WithPagination;

class PedidoIndex extends Component
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

    public function toggleVigente($pedidoId, $newValue)
    {
        $pedido = Pedido::findOrFail($pedidoId);
        $pedido->vigente = $newValue;
        $pedido->save();
    }

    public function render()
    {
        // $pedidos = Pedido::all();
        $pedidos = Pedido::latest('id')
            ->join('clientes', 'pedidos.cliente_id', '=', 'clientes.id') // Unir la tabla clientes
            ->select('pedidos.*', 'clientes.numeroDoc') // Seleccionar el campo numeroDoc de la tabla clientes
            ->where(function ($query) {
                $query->where('pedidos.codigo', 'LIKE', '%' . $this->search . '%') // Filtrar por el código de pedido
                    ->orWhere('clientes.numeroDoc', 'LIKE', '%' . $this->search . '%'); // Filtrar por el numeroDoc del cliente
            })
            ->paginate(15);



        return view('livewire.admin.pedido-index', compact('pedidos'));
    }
}
