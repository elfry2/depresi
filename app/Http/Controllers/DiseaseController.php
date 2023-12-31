<?php

namespace App\Http\Controllers;

use App\Models\Rule;
use App\Models\Disease;
use App\Models\Preference;
use App\Models\Probability;
use GuzzleHttp\Psr7\Request;
use Illuminate\Pagination\Paginator;
use App\Http\Requests\StoreDiseaseRequest;
use App\Http\Requests\UpdateDiseaseRequest;
use App\Models\ConsequentDisease;

class DiseaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Gangguan',
            'resource' => 'diseases',
            'items' => new Disease
        ];

        if(request('q'))
        $data['items']
        = $data['items']->where('name', 'like', '%' . request('q') . '%');

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

        // $items = new Disease;
        // $resource = 'diseases';
        
        // if(request('q'))
        // $items = $items->where('name', 'like', '%' . request('q') . '%');

        // $sorting = PreferenceController::get($resource . 'Sorting') ?: 'id';
        // $sortingDirection =PreferenceController::get($resource . 'SortingDirection') ?: 'asc';

        // $items = $items->orderBy($sorting, $sortingDirection);

        // return view('diseases', [
        //     'title' => 'Gangguan',
        //     'items' => $items->paginate(config('app.itemsPerPage')),
        //     'resource' => $resource,
        //     'preferences' => [
        //         'sorting' => $sorting,
        //         'sortingDirection' => $sortingDirection
        //     ]
        // ]);
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
     * @param  \App\Http\Requests\StoreDiseaseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDiseaseRequest $request)
    {
        $rules = [
            'name' => 'required|max:255|unique:diseases',
            'probability' => 'required|decimal:0,5',
            'is_healthy' => 'boolean'
        ];

        $request = $request->validate($rules);

        Disease::create($request);

        return redirect('/diseases')
        ->with('message', (object) [
            'type' => 'success',
            'content' => 'Gangguan berhasil ditambahkan.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Disease  $disease
     * @return \Illuminate\Http\Response
     */
    public function show(Disease $disease)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Disease  $disease
     * @return \Illuminate\Http\Response
     */
    public function edit(Disease $disease)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDiseaseRequest  $request
     * @param  \App\Models\Disease  $disease
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDiseaseRequest $request, Disease $disease)
    {
        $rules = [
            'name' => 'required|max:255',
            'probability' => 'required|decimal:0,5',
            'is_healthy' => 'boolean'
        ];

        $request->validate($rules);

        if($request->name !== $disease->name) $request->validate([
            'name' => 'unique:diseases'
        ]);

        $disease->update([
            'name' => $request->name,
            'probability' => $request->probability,
            'is_healthy' => $request->is_healthy == true
        ]);

        return redirect('/diseases')
        ->with('message', (object) [
            'type' => 'success',
            'content' => 'Gangguan berhasil disunting.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Disease  $disease
     * @return \Illuminate\Http\Response
     */
    public function destroy(Disease $disease)
    {
        Probability::where('disease_id', $disease->id)->delete();

        ConsequentDisease::where('disease_id', $disease->id)->delete();

        $disease->delete();

        return redirect('/diseases')
        ->with('message', (object) [
            'type' => 'success',
            'content' => 'Gangguan berhasil dihapus.'
        ]);
    }
}
