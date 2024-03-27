<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name' => 'Administrador']);
        $role2 = Role::create(['name' => 'Vendedor']);
        $role3 = Role::create(['name' => 'Jefe de Ensamblaje']);
        $role4 = Role::create(['name' => 'Jefe de Almacen']);
        $role5 = Role::create(['name' => 'Jefe de Compras']);


        Permission::create([
            'name' => 'admin.home',
            'descripcion' => 'Ver el Dashboard'
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);

        Permission::create([
            'name' => 'admin.roles.index',
            'descripcion' => 'Lista de Roles'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.roles.create',
            'descripcion' => 'Crear Rol'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.roles.edit',
            'descripcion' => 'Editar Rol'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.roles.destroy',
            'descripcion' => 'Eliminar Rol'
        ])->syncRoles([$role1]);

        Permission::create([
            'name' => 'admin.clientes.index',
            'descripcion' => 'Listados de Clientes'
        ])->syncRoles([$role1, $role2]);
        Permission::create([
            'name' => 'admin.clientes.create',
            'descripcion' => 'Crear Clientes'
        ])->syncRoles([$role1, $role2]);
        Permission::create([
            'name' => 'admin.clientes.edit',
            'descripcion' => 'Editar Clientes'
        ])->syncRoles([$role1, $role2]);
        Permission::create([
            'name' => 'admin.clientes.destroy',
            'descripcion' => 'Eliminar CLiente'
        ])->syncRoles([$role1, $role2]);

        Permission::create([
            'name' => 'admin.users.index',
            'descripcion' => 'Lista de Trabajadores'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.users.create',
            'descripcion' => 'Crear Trabajadores'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.users.edit',
            'descripcion' => 'Editar Trabajadores'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.users.destroy',
            'descripcion' => 'Eliminar Trabajadores'
        ])->syncRoles([$role1]);

        Permission::create([
            'name' => 'admin.pedidos.index',
            'descripcion' => 'Listado de Pedidos'
        ])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create([
            'name' => 'admin.pedidos.create',
            'descripcion' => 'Crear Pedidos'
        ])->syncRoles([$role1, $role2]);
        Permission::create([
            'name' => 'admin.pedidos.edit',
            'descripcion' => 'Editar Pedidos'
        ])->syncRoles([$role1, $role2]);
        Permission::create([
            'name' => 'admin.pedidos.destroy',
            'descripcion' => 'Eliminar Pedidos'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.pedidos.finalizarPedido',
            'descripcion' => 'Finalizar Pedido'
        ])->syncRoles([$role1, $role3]);
        Permission::create([
            'name' => 'admin.pedidos.entregarPedido',
            'descripcion' => 'Entregar Pedidos'
        ])->syncRoles([$role1, $role4]);


        Permission::create([
            'name' => 'admin.categoriesComponents.index',
            'descripcion' => 'Lista de Categorias'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.categoriesComponents.create',
            'descripcion' => 'Crear Categorias'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.categoriesComponents.edit',
            'descripcion' => 'Editar Categorias'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.categoriesComponents.destroy',
            'descripcion' => 'Eliminar Categorias'
        ])->syncRoles([$role1]);

        Permission::create([
            'name' => 'admin.componentes.index',
            'descripcion' => 'Lista de Componentes'
        ])->syncRoles([$role1, $role2, $role4]);
        Permission::create([
            'name' => 'admin.componentes.create',
            'descripcion' => 'Crear Componentes'
        ])->syncRoles([$role1, $role4]);
        Permission::create([
            'name' => 'admin.componentes.edit',
            'descripcion' => 'Editar Componentes'
        ])->syncRoles([$role1, $role4]);
        Permission::create([
            'name' => 'admin.componentes.destroy',
            'descripcion' => 'Eliminar Componentes'
        ])->syncRoles([$role1, $role4]);

        Permission::create([
            'name' => 'admin.marcas.index',
            'descripcion' => 'Lista de Marcas'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.marcas.create',
            'descripcion' => 'Crear Marcas'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.marcas.edit',
            'descripcion' => 'Editar Marcas'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.marcas.destroy',
            'descripcion' => 'Eliminar Marcas'
        ])->syncRoles([$role1]);



        Permission::create([
            'name' => 'admin.documentos.index',
            'descripcion' => 'Lista tipos de documentos'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.documentos.create',
            'descripcion' => 'Crear tipos de Documentos'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.documentos.edit',
            'descripcion' => 'Editar tipos de Documentos'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.documentos.destroy',
            'descripcion' => 'Eliminar Tipos de Documentos'
        ])->syncRoles([$role1]);


        Permission::create([
            'name' => 'admin.ordenEnsamblaje.index',
            'descripcion' => 'Ver lista de ordenes de ensamblaje'
        ])->syncRoles([$role1, $role3]);
        Permission::create([
            'name' => 'admin.ordenEnsamblaje.crear',
            'descripcion' => 'Crear orden de ensamblaje'
        ])->syncRoles([$role1, $role3]);        
        Permission::create([
            'name' => 'admin.ordenEnsamblaje.aprobar_orden',
            'descripcion' => 'Aprobar orden de ensamblaje'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.ordenEnsamblaje.detalle_pedido',
            'descripcion' => 'OrdenEnsamblaje/Ver detalles del pedido'
        ])->syncRoles([$role1, $role3]);
        


        Permission::create([
            'name' => 'admin.solicitudComponentes.index',
            'descripcion' => 'Ver lista de solicitudes'
        ])->syncRoles([$role1, $role3, $role4]);
        Permission::create([
            'name' => 'admin.solicitudComponentes.detalle_orden',
            'descripcion' => 'Ver detalles de la orden'
        ])->syncRoles([$role1, $role3, $role4]);
        Permission::create([
            'name' => 'admin.solicitudComponentes.detalle_pedido',
            'descripcion' => 'Ver detalles Orden/Pedido'
        ])->syncRoles([$role1, $role3, $role4]);
        Permission::create([
            'name' => 'admin.solicitudComponentes.generar_pdf',
            'descripcion' => 'Descargar PDF solicitud de Componentes'
        ])->syncRoles([$role1, $role3, $role4]);
        Permission::create([
            'name' => 'admin.solicitudComponentes.aprobar_solicitud',
            'descripcion' => 'Aprobar solicitud de Componentes'
        ])->syncRoles([$role1,  $role4]);
        Permission::create([
            'name' => 'admin.solicitudComponentes.CambiarEstadoSolicitud',
            'descripcion' => 'Actualizar estado Solicitud'
        ])->syncRoles([$role1,  $role4]);


        Permission::create([
            'name' => 'admin.EnvioPedidos.index',
            'descripcion' => 'Enviar Pedidos'
        ])->syncRoles([$role1,  $role3]);


        Permission::create([
            'name' => 'admin.Kardex.index',
            'descripcion' => 'Kardex'
        ])->syncRoles([$role1,  $role4]);


        Permission::create([
            'name' => 'admin.reposiciones.index',
            'descripcion' => 'Ordenes de Reposicion'
        ])->syncRoles([$role1,  $role4,  $role5]);


        Permission::create([
            'name' => 'admin.compras.index',
            'descripcion' => 'Lista de Reposiciones'
        ])->syncRoles([$role1,  $role5]);

    }
}
