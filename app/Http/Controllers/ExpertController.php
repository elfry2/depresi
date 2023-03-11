<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpertRequest;
use App\Http\Requests\UpdateExpertRequest;
use App\Models\Expert;
use Illuminate\Support\Facades\Storage;

class ExpertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Pakar',
            'resource' => 'experts',
            'items' => new Expert
        ];

        if(request('q'))
        $data['items']
        = $data['items']->where('name', 'like', '%' . request(
            'q') . '%')->orWhere('address', 'like', '%' . request('q') . '%');

        $data['preferences'] = [
            'sorting'
            => PreferenceController::get($data['resource'] . 'Sorting') ?: 'id',
            'sortingDirection' => PreferenceController::get(
                $data['resource'] . 'SortingDirection') ?: 'asc'
        ];

        $data['items'] = $data['items']->orderBy($data['preferences'][
            'sorting'], $data['preferences']['sortingDirection']);

        $data['items'] = $data['items']->paginate(config('app.itemsPerPage'));

        return view('dashboard.' . $data['resource'] . '.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreExpertRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExpertRequest $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'address' => 'nullable|max:255',
            'phone_number' => 'nullable|numeric',
            'photo' => 'image|max:10240'
        ]);

        if($request->has_whatsapp && $request->has_whatsapp == 'on') {
            $validatedData['has_whatsapp'] = true;
        } else $validatedData['has_whatsapp'] = false;
        
        if($request->photo) {
            $validatedData['path_to_photo']
            = $request->file('photo')->store('expert-photos');
        }

        Expert::create($validatedData);

        return redirect('/experts')
        ->with('message', (object) [
            'type' => 'success',
            'content' => 'Pakar berhasil ditambahkan.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expert  $expert
     * @return \Illuminate\Http\Response
     */
    public function show(Expert $expert)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expert  $expert
     * @return \Illuminate\Http\Response
     */
    public function edit(Expert $expert)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateExpertRequest  $request
     * @param  \App\Models\Expert  $expert
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateExpertRequest $request, Expert $expert)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'address' => 'nullable|max:255',
            'phone_number' => 'nullable|numeric',
            'photo' => 'image|max:10240'
        ]);

        if($request->has_whatsapp && $request->has_whatsapp == 'on') {
            $validatedData['has_whatsapp'] = true;
        } else $validatedData['has_whatsapp'] = false;
        
        if($request->photo) {
            if($expert->path_to_photo) Storage::delete($expert->path_to_photo);
            $validatedData['path_to_photo'] = $request->file('photo')->store('expert-photos');
        }

        $expert->update($validatedData);

        return redirect('/experts')
        ->with('message', (object) [
            'type' => 'success',
            'content' => 'Pakar berhasil disunting.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expert  $expert
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expert $expert)
    {
        if($expert->path_to_photo) Storage::delete($expert->path_to_photo);
        $expert->delete();

        return redirect('/experts')
        ->with('message', (object) [
            'type' => 'success',
            'content' => 'Pakar berhasil dihapus.'
        ]);
    }
}
