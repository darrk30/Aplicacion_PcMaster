<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Cliente;
use App\Models\Componente;
use App\Models\Marca;
use App\Models\Pedido;
use Livewire\Component;
use Livewire\WithPagination;

class PedidoCreate extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap";

    public $search;
    public $perPage = 8;
    public $cartItems = [];

    public function render()
    {       
        $componentes = Componente::where('descripcion', 'like', '%' . $this->search . '%')
            ->paginate($this->perPage);

        return view('livewire.admin.pedido-create', compact('componentes'));
    }

    public function addToCart($componenteId)
    {
        $componente = Componente::find($componenteId);
        $existingItem = collect($this->cartItems)->firstWhere('id', $componenteId);

        if ($existingItem) {
            // Si el componente ya está en el carrito, aumentar la cantidad en 1
            $existingItem['qty']++;
        } else {
            // Si el componente no está en el carrito, agregarlo con cantidad 1
            $this->cartItems[] = [
                'id' => $componente->id,
                'descripcion' => $componente->descripcion,
                'precio' => $componente->precio,
                'qty' => 1
            ];
        }

        session()->flash('success_message', 'Componente agregado al carrito.');
    }

    public function removeFromCart($componenteId)
    {
        $this->cartItems = array_values(
            array_filter($this->cartItems, function ($item) use ($componenteId) {
                return $item['id'] !== $componenteId;
            })
        );

        session()->flash('success_message', 'Componente eliminado del carrito.');
    }

    public function updateQuantity($componenteId, $newQuantity)
    {
        foreach ($this->cartItems as &$item) {
            if ($item['id'] === $componenteId) {
                $item['qty'] = $newQuantity;
                break;
            }
        }

        session()->flash('success_message', 'Cantidad actualizada.');
    }

    public function getCartSubtotal()
    {
        // Calcular el subtotal sumando los precios de todos los componentes en el carrito
        $subtotal = collect($this->cartItems)->sum(function ($item) {
            return $item['precio'] * $item['qty'];
        });

        // Formatear el subtotal como moneda con dos decimales
        return number_format($subtotal, 2);
    }
}








    //     public $numeroDocumento;
    //     public $codigoComp;
    //     public $descripcionComp;
    //     public $stockComp;
    //     public $precioComp;
    //     public $clienteId;
    //     public $nombres;
    //     public $apellidos;
    //     public $clienteEncontrado = false;
    //     public $mostrarMensaje = false;
    //     public $ComponenteEncontrado = false;
    //     public $mostrarMensajeComponente = false;
    //     public $search;
    //     public $marca_id;
    //     public $categoria_id;
    //     public $codigoPedido;
    //     public $componentesSeleccionados = []; // Propiedad para almacenar componentes seleccionados
    //     public $marcas;
    //     public $categorias;
    //     public $cantidad;

    //     use WithPagination;

    //     protected $paginationTheme = "bootstrap";

    //     public function updatingSearch()
    //     {
    //         $this->resetPage();
    //     }

    //     public function toggleVigente($componenteId, $newValue)
    //     {
    //         $componente = Componente::findOrFail($componenteId);
    //         $componente->vigente = $newValue;
    //         $componente->save();
    //     }

    //     public function buscarCliente()
    // {
    //     // Reiniciar las variables
    //     $this->clienteEncontrado = false;
    //     $this->mostrarMensaje = false;

    //     $cliente = Cliente::where('numeroDoc', $this->numeroDocumento)->first();

    //     if ($cliente) {
    //         $this->clienteEncontrado = true;
    //         $this->clienteId = $cliente->id;
    //         $this->nombres = $cliente->nombres;
    //         $this->apellidos = $cliente->apellidos;

    //         // Limpiar el campo de búsqueda del cliente
    //         $this->numeroDocumento = '';
    //     } else {
    //         $this->mostrarMensaje = true;
    //     }
    // }

    // public function buscarComponente()
    // {
    //     $componente = Componente::where('codigo', $this->codigoComp)->first();

    //     if ($componente) {
    //         $this->descripcionComp = $componente->descripcion;
    //         $this->stockComp = $componente->stock;
    //         $this->precioComp = $componente->precio;
    //     } else {
    //         // Restablecer los valores a nulo si no se encuentra el componente
    //         $this->descripcionComp = null;
    //         $this->stockComp = null;
    //         $this->precioComp = null;
    //     }
    // }





    //     public function mostrarCrearCliente()
    //     {
    //         // Redireccionar a la ruta de creación de cliente
    //         return redirect()->route('admin.clientes.create');
    //     }

    //     public function mount()
    //     {
    //         // Obtiene el último ID de la tabla de ventas
    //         $ultimoID = Pedido::max('id');

    //         // Incrementa el último ID en 1
    //         $nuevoID = $ultimoID + 1;

    //         // Formatea el código de venta con ceros a la izquierda
    //         $this->codigoPedido = 'VENTA-' . str_pad($nuevoID, 4, '0', STR_PAD_LEFT);

    //         // Cargar todos los componentes, marcas y categorías
    //         $this->marcas = Marca::all();
    //         $this->categorias = Category::all();
    //     }

    //     public function render()
    //     {    
    //         $componentes = Componente::all();
    //         return view('livewire.admin.pedido-create', compact('componentes'));
    //     }
// }
