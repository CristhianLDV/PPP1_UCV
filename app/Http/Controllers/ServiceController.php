<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;

class ServiceController extends Controller
{

    public function index()
    {
        return view('admin.services', ['services' => Service::all()]);
   
    }

    public function store(StoreServiceRequest $request)
    {
        $service = new Service();
        $this->fillServiceData($service, $request);

            flash()->success('Éxito', 'Servicio creado exitosamente.');
    return redirect()->route('services.index');
    }

    public function show($id)
    {
        $service = Service::findOrFail($id);
        return view('admin.show_service', ['service' => $service]);
    }

    public function update(UpdateServiceRequest $request, $id)
    {
        $service = Service::findOrFail($id);
        $this->fillServiceData($service, $request);
        
        flash()->success('Éxito', 'Servicio actualizado exitosamente.');
        return redirect()->route('services.index');
    }

    public function destroy($id)
    {

        $service = Service::findOrFail($id);
        $service->delete();
       
        flash()->success('Éxito', 'Servicio eliminado correctamente.');
        return redirect()->route('services.index');
    }

    private function fillServiceData(Service $service, $request)
    {
        $service->name = $request->name;
        $service->description = $request->description;
        $service->save();
    }
}
