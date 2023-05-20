<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\dashboard\ClientStoreRequest;
use App\Http\Requests\dashboard\ClientUpdateRequest;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{

        // middleware permissions
        public function __construct()
        {
            $this->middleware('permission:read_clients')->only('index');
            $this->middleware('permission:create_clients')->only('create');
            $this->middleware('permission:update_clients')->only('edit');
            $this->middleware('permission:delete_clients')->only('destroy');
        }

    public function index(Request $request)
    {
        $clients = Client::when($request->search, function ($q) use ($request) {
            return $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('phone', 'like', '%' . $request->search . '%')
                ->orWhere('address', 'like', '%' . $request->search . '%');
        })->latest()->paginate(10);
        
        return view('dashboard.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('dashboard.clients.create');
    }

    public function store(ClientStoreRequest $request)
    {
        // validate request

        // prepare data
        $data = [
            'name' => $request->name,
            'phone' => array_filter($request->phone),
            'address' => $request->address
        ];

        // insert in db
        Client::create($data);
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.clients.index');
    }

    public function edit(Client $client)
    {
        return view('dashboard.clients.edit', compact('client'));
    }

    public function update(ClientUpdateRequest $request, Client $client)
    {
        // validate request

        // prepare data
        $data = [
            'name' => $request->name,
            'phone' => array_filter($request->phone),
            'address' => $request->address
        ];

        // insert in db
        $client->update($data);
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.clients.index');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.clients.index');
    }
}
