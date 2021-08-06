<?php

namespace App\Http\Controllers;

use App\Models\Comuna;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ComunasController extends Controller
{
    public function index(){
        $cliente = curl_init();
        curl_setopt($cliente, CURLOPT_URL, 'https://apis.digital.gob.cl/dpa/comunas');
        curl_setopt($cliente, CURLOPT_HEADER, 0);
        curl_setopt($cliente, CURLOPT_RETURNTRANSFER, true);
        $comunas = json_decode(curl_exec($cliente));
        curl_close($cliente);
        foreach ($comunas as $comuna){
            $res = Comuna::where('codigo', '=', $comuna->codigo)->first();
            if($res){
                echo "La $comuna->nombre ya esta registrada";
            }else{
                $com = new Comuna();
                $com->codigo = $comuna->codigo;
                $com->tipo = $comuna->tipo;
                $com->nombre = $comuna->nombre;
                $com->lat = $comuna->lat;
                $com->lng = $comuna->lng;
                $com->url = $comuna->url;
                $com->codigo_padre = $comuna->codigo_padre;
                $com->save();

                //return $comunas;
            }
        }
    }

    public function show($codigo){
        $cliente = curl_init();
        curl_setopt($cliente, CURLOPT_URL, "https://apis.digital.gob.cl/dpa/comunas/$codigo");
        curl_setopt($cliente, CURLOPT_HEADER, 0);
        curl_setopt($cliente, CURLOPT_RETURNTRANSFER, true);
        $provincia = json_decode(curl_exec($cliente));
        curl_close($cliente);
        return json_encode($provincia);
    }

    public function provincia($codigo){
        $cliente = curl_init();
        curl_setopt($cliente, CURLOPT_URL, "https://apis.digital.gob.cl/dpa/provincias/$codigo/comunas");
        curl_setopt($cliente, CURLOPT_HEADER, 0);
        curl_setopt($cliente, CURLOPT_RETURNTRANSFER, true);
        $provincia = json_decode(curl_exec($cliente));
        curl_close($cliente);
        return json_encode($provincia);
    }

    public function region($codigo){
        $cliente = curl_init();
        curl_setopt($cliente, CURLOPT_URL, "https://apis.digital.gob.cl/dpa/regiones/$codigo/comunas");
        curl_setopt($cliente, CURLOPT_HEADER, 0);
        curl_setopt($cliente, CURLOPT_RETURNTRANSFER, true);
        $region = json_decode(curl_exec($cliente));
        curl_close($cliente);
        return json_encode($region);
    }
}
