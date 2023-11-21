<?php

namespace App\Http\Controllers;

use App\Models\Disease;
use App\Models\Symptom;
use App\Models\AntecedentSymptom;
use App\Models\Probability;
use App\Models\ConsequentSymptom;
use App\Http\Requests\StoreSymptomRequest;
use App\Http\Requests\UpdateSymptomRequest;

class SymptomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Gejala',
            'resource' => 'symptoms',
            'items' => new Symptom,
            'items2' => Disease::all()
        ];

        if (request('q'))
            $data['items']
                = $data['items']->where('name', 'like', '%' . request('q') . '%');

        $data['preferences'] = [
            'sorting'
            => PreferenceController::get($data['resource'] . 'Sorting') ?: 'id',
            'sortingDirection' => PreferenceController::get(
                $data['resource'] . 'SortingDirection'
            ) ?: 'asc'
        ];

        $data['items'] = $data['items']->orderBy($data['preferences']['sorting'], $data['preferences']['sortingDirection']);

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
     * @param  \App\Http\Requests\StoreSymptomRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSymptomRequest $request)
    {
        $rules = [
            'name' => 'required|max:255|unique:symptoms',
        ];

        $request->validate($rules);

        $symptom = Symptom::create([
            'name' => $request->name
        ]);

        foreach (Disease::all() as $disease) {
            Probability::create([
                'symptom_id' => $symptom->id,
                'disease_id' => $disease->id,
                'amount'
                => $request->input('probabilityIfOccursDiseaseWithId' . $disease->id)
            ]);
        }

        return redirect('/symptoms')
            ->with('message', (object) [
                'type' => 'success',
                'content' => 'Gejala berhasil ditambahkan.'
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Symptom  $symptom
     * @return \Illuminate\Http\Response
     */
    public function show(Symptom $symptom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Symptom  $symptom
     * @return \Illuminate\Http\Response
     */
    public function edit(Symptom $symptom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSymptomRequest  $request
     * @param  \App\Models\Symptom  $symptom
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSymptomRequest $request, Symptom $symptom)
    {
        $rules = [
            'name' => 'required|max:255',
        ];

        $request->validate($rules);

        if($request->name !== $symptom->name) $request->validate([
            'name' => 'unique:symptoms'
        ]);

        $symptom->update([
            'name' => $request->name
        ]);

        foreach (Disease::all() as $disease) {
            Probability::updateOrCreate([
                'symptom_id' => $symptom->id,
                'disease_id' => $disease->id
            ], [
                'amount'
                => $request
                ->input('probabilityIfOccursDiseaseWithId' . $disease->id)
            ]);
        }

        return redirect('/symptoms')
            ->with('message', (object) [
                'type' => 'success',
                'content' => 'Gejala berhasil disunting.'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Symptom  $symptom
     * @return \Illuminate\Http\Response
     */
    public function destroy(Symptom $symptom)
    {
        Probability::where('symptom_id', $symptom->id)->delete();
        
        AntecedentSymptom::where('symptom_id', $symptom->id)->delete();

        ConsequentSymptom::where('symptom_id', $symptom->id)->delete();
        
        $symptom->delete();

        return redirect('/symptoms')
        ->with('message', (object) [
            'type' => 'success',
            'content' => 'Gejala berhasil dihapus.'
        ]);
    }
}
