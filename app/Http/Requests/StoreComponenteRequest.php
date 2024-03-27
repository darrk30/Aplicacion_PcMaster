<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreComponenteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        // if($this->user_id == auth()->user()->id){
        //     return true;
        // }else{
        //     return false;
        // }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {           
        $componente = $this->route()->parameter('componente');
        
        $rules = [
            'codigo' => 'required',
            'descripcion' => 'required',
            'precio' => 'required',
            'stock' => 'required',
            'stockmin' => 'required',            
            'category_id' => 'required',
            'marca_id' => 'required',
            'slug' => 'required|unique:componentes',
            'vigente' => 'required|in:1,0',
            'file' => 'image',
        ];

        if ($componente) {
            $rules['slug'] = "required|unique:marcas,slug,$componente->id";
        }

        // if($this->vigente == 0){
        //     $rules = array_merge($rules,
        //     [
                
        //     ]);
        // }

        return $rules;
    }
}
