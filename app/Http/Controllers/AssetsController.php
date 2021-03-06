<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Exception\ClientException; 
use GuzzleHttp\Client;
use App\Asset;
use App\Http\Controllers;

class AssetsController extends Controller
{
    //metodo que retorna los equipos de una empresa
    public function index($company_id){
        $assets = DB::table('assets')
             ->whereIn('company_id', [$company_id])
             ->get();
        return response()->json($assets);
    }
    //metodo que retorna los equipos de una ubicación
    public function assets_of_location($location_id){
        $assets = DB::table('assets')
             ->whereIn('location_id', [$location_id])
             ->get();
        return response()->json($assets);
    }
    //metodo que guarda un equipo
    public function store(Request $request){
        try{
    		$asset = new Asset([
                'plaque'=>$request->input('plaque'),
                'model'=>$request->input('model'),
                'description'=>$request->input('description'),
                'last_change'=>$request->input('last_change'),
                'install_date'=>$request->input('install_date'),
                'type_id'=>$request->input('type_id'),
                'location_id'=>$request->input('location_id'),
                'company_id'=>$request->input('company_id'),
                'state'=>$request->input('state'),

                ]);
    		$asset->save();
    		return response()->json(['status'=>true, 'Equipo creado'], 200);
    	} catch (\Exception $e){
            echo $e->getCode() . $e->getLine() . $e->getMessage();
            //Log::critical("No se ha podido añadir: {$e->getCode()} , {$e->getLine()} , {$e->getMessage()}");
            return response('Someting bad', 500 );
    	}
    }
    //Función que retorna el equipo consultado
    public function show($id)
    {
        try{
    		$asset = Asset::find($id);
    		if(!$asset){
    			return response()->json(['El equipo no existe'], 404);
    		}
    		return response()->json($asset, 200);
    	} catch (\Exception $e){
            Log::critical("No se ha podido encontrar el equipo: {$e->getCode()} , {$e->getLine()} , {$e->getMessage()}");
    		return response('Someting bad', 500 );
    	}
    }
    //Función que modifica un equipo
    public function update(Request $request, $id)
    {
         try{
    		$asset = Asset::find($id);
    		if(!$asset){
    			return response()->json(['No existe...'], 404);
    		}
    		
            $asset->update($request->all());
    		return response(array(
                'error' => false,
                'message' =>'Equipo Modificado',
               ),200);
    	} catch (\Exception $e){
    		Log::critical("No se ha podido editar: {$e->getCode()} , {$e->getLine()} , {$e->getMessage()}");
    		return response('Someting bad', 500 );
    	}
    }
    //función que elimina un equipo
    public function destroy($id)
    {
        try{
    		$asset = Asset::find($id);
    		if(!$asset){
    			return response()->json(['No existe ese producto'], 404);
    		}
    		
    		$asset->delete();
    		return response()->json('Equipo eliminado..', 200);
    	} catch (\Exception $e){
    		Log::critical("No se ha podido eliminar: {$e->getCode()} , {$e->getLine()} , {$e->getMessage()}");
    		return response('Someting bad', 500 );
    	}
    }
}
