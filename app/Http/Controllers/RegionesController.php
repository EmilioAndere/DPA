<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class RegionesController extends Controller
{
    public function index(){
        $cliente = curl_init();
        curl_setopt($cliente, CURLOPT_URL, 'https://apis.digital.gob.cl/dpa/regiones');
        curl_setopt($cliente, CURLOPT_HEADER, 0);
        curl_setopt($cliente, CURLOPT_RETURNTRANSFER, true);
        $regiones = json_decode(curl_exec($cliente));
        curl_close($cliente);
        foreach ($regiones as $region){
            $res = Region::where('codigo', '=', $region->codigo)->first();
            if($res){
                echo "La $region->nombre ya esta registrada<br>";
            }else{
                $reg = new Region();
                $reg->codigo = $region->codigo;
                $reg->tipo = $region->tipo;
                $reg->nombre = $region->nombre;
                $reg->lat = $region->lat;
                $reg->lng = $region->lng;
                $reg->url = "localhost:8000/api/weather/$region->lat,$region->lng";
                $reg->codigo_padre = $region->codigo_padre;
                $reg->save();
                //return $regiones;
            }
        }
        return $regiones;
    }

    public function show($codigo){
        $cliente = curl_init();
        curl_setopt($cliente, CURLOPT_URL, "https://apis.digital.gob.cl/dpa/regiones/$codigo");
        curl_setopt($cliente, CURLOPT_HEADER, 0);
        curl_setopt($cliente, CURLOPT_RETURNTRANSFER, true);
        $region = json_decode(curl_exec($cliente));
        curl_close($cliente);
        return json_encode($region);
    }

    public function climate($region){
        $reg = Region::where('nombre', '=', $region)->first();
        $cliente = curl_init();
        curl_setopt($cliente, CURLOPT_URL, $reg->url);
        curl_setopt($cliente, CURLOPT_HEADER, 0);
        curl_setopt($cliente, CURLOPT_RETURNTRANSFER, true);
        $resp = json_decode(curl_exec($cliente));
        curl_close($cliente);
        return $resp;
    }
}
