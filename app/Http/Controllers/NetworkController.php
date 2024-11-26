<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Network;
use App\Models\Network212;

class NetworkController extends Controller
{
    public function index(Request $request)
    {
        $network = $request->session()->get('network', '52'); // Valor por defecto

        if ($network === '212') {
            $ips = Network212::all();
        } else {
            $ips = Network::where('IP', 'LIKE', "10.82.{$network}.%")->get();
        }

        return view('networks.index', compact('ips', 'network'));
    }

    public function show($id)
    {
        $network = session('network', '52'); // Valor por defecto

        if ($network === '212') {
            $ipDetails = Network212::findOrFail($id);
        } else {
            $ipDetails = Network::findOrFail($id);
        }

        return response()->json(['html' => view('networks.show', compact('ipDetails', 'network'))->render()]);
    }

    public function update(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'network' => 'required|string',
            'IP_ID' => 'required|integer',
            'STATUS' => 'required|string',
            'INNO' => 'nullable|string',
            'PROJECT' => 'nullable|string',
            'AREA' => 'nullable|string',
            'PROCESS' => 'nullable|string',
            'TYPE' => 'nullable|string',
            'PERSON_IN_CHARGE' => 'nullable|string',
            'NO_EMPLOYEE' => 'nullable|string',
            'NAME' => 'nullable|string',
        ]);
    
        // Seleccionar la tabla adecuada según el IP_ID
        if ($validatedData['IP_ID'] > 100) {
            $network = Network::findOrFail($validatedData['IP_ID']);
        } else {
            $network = Network212::findOrFail($validatedData['IP_ID']);
        }
    
        // Actualizar los datos
        $network->fill($validatedData);
        $network->save();
    
        // Redirigir a la página principal sin exponer datos en la URL
        return redirect()->route('networks.index')->with('success', 'Datos actualizados con éxito.');
    }
    
    
    public function setNetwork(Request $request)
    {
        $network = $request->input('network');
        $request->session()->put('network', $network);

        return redirect()->route('networks.index');
    }

    public function setIp(Request $request, $id)
    {
        $request->session()->put('ip_id', $id);
        return response()->json(['success' => 'IP seleccionada']);
    }

}
