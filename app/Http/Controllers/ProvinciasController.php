<?php

namespace App\Http\Controllers;

use App\Models\Provincia;
use Illuminate\Http\Request;

class ProvinciasController extends Controller
{
    public function index(){
        $cliente = curl_init();
        curl_setopt($cliente, CURLOPT_URL, 'https://apis.digital.gob.cl/dpa/provincias');
        curl_setopt($cliente, CURLOPT_HEADER, 0);
        curl_setopt($cliente, CURLOPT_RETURNTRANSFER, true);
        $provincias = json_decode(curl_exec($cliente));
        curl_close($cliente);

        foreach ($provincias as $provincia){
           $prov = Provincia::where('codigo', '=', $provincia->codigo)->first();
           if($prov){
               echo "La $provincia->nombre ya esta registrada";
           }else{
               $prov = new Provincia();
               $prov->codigo = $provincia->codigo;
               $prov->tipo = $provincia->tipo;
               $prov->nombre = $provincia->nombre;
               $prov->lat = $provincia->lat;
               $prov->lng = $provincia->lng;
               $prov->url = $provincia->url;
               $prov->codigo_padre = $provincia->codigo_padre;
               $prov->save();
               //return $provincias;
           }
        }
        return $provincias;
    }

    public function show($codigo){
        $cliente = curl_init();
        curl_setopt($cliente, CURLOPT_URL, "https://apis.digital.gob.cl/dpa/provincias/$codigo");
        curl_setopt($cliente, CURLOPT_HEADER, 0);
        curl_setopt($cliente, CURLOPT_RETURNTRANSFER, true);
        $provincia = json_decode(curl_exec($cliente));
        curl_close($cliente);
        return json_encode($provincia);
    }

    public function region($codigo){
        $cliente = curl_init();
        curl_setopt($cliente, CURLOPT_URL, "https://apis.digital.gob.cl/dpa/regiones/$codigo/provincias");
        curl_setopt($cliente, CURLOPT_HEADER, 0);
        curl_setopt($cliente, CURLOPT_RETURNTRANSFER, true);
        $provincias = json_decode(curl_exec($cliente));
        curl_close($cliente);
        return json_encode($provincias);
    }
}
