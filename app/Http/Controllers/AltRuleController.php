<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\AltRule;
use App\Models\Disease;
use App\Models\Symptom;

class AltRuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected static $title = 'Aturan';
    protected static $resource = 'rules';
    
    public function index()
    {
        
        $data = [
            'title' => self::$title,
            'resource' => self::$resource,
            'preferences' => [
                'sorting'
                => PreferenceController::get(self::$resource . 'Sorting') ?: 'id',
                'sortingDirection' => PreferenceController::get(
                    self::$resource . 'SortingDirection') ?: 'asc'
                ],
            'items' => new AltRule,
            'items2' => Disease::all(),
            'maxScore' => DB::table('symptoms')->count() * 10
        ];

        $data['items'] = $data['items']->orderBy(
            $data['preferences']['sorting'],
            $data['preferences']['sortingDirection']
        );

        $diseaseIds = array_map(function($item) {
            return $item['id'];
        }, Disease::where('name', 'like', 'q')->get()->toArray());

        if(request('q')) {
            $data['items']->whereIn('disease_id', $diseaseIds);
        }

        $data['items'] = $data['items']->paginate(config('app.itemsPerPage'));

        return view('dashboard.alt-rules.index', $data);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $diseaseIds = array_map(function($item) {
            return $item['id'];
        }, Disease::all()->toArray());

        $rules = [
            'min' => 'decimal:0,5',
            'max' => 'decimal:0,5',
            'disease_id' => ['integer', Rule::in($diseaseIds)]
        ];

        AltRule::create($request->validate($rules));

        return redirect('/' . self::$resource)
        ->with('message', (object) [
            'type' => 'success',
            'content' => 'Aturan berhasil ditambahkan.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->method === 'changeId') {
            $current = AltRule::find($id);

            $target = AltRule::find($request->id);

            AltRule::where('id', $target->id)
            ->update([
               'min' => $current->min,
               'max' => $current->max,
               'disease_id' => $current->disease_id
            ]);
            
            AltRule::where('id', $current->id)
            ->update([
               'min' => $target->min,
               'max' => $target->max,
               'disease_id' => $target->disease_id
            ]);

            return redirect('/rules')
            ->with('message', (object) [
                'type' => 'success',
                'content' => 'Id. berhasil diganti.'
            ]);
        }

        $diseaseIds = array_map(function($item) {
            return $item['id'];
        }, Disease::all()->toArray());

        $rules = [
            'min' => 'decimal:0,5',
            'max' => 'decimal:0,5',
            'disease_id' => ['integer', Rule::in($diseaseIds)]
        ];

        AltRule::where('id', $id)
        ->update($request->validate($rules));

        return redirect('/' . self::$resource)
        ->with('message', (object) [
            'type' => 'success',
            'content' => self::$title . ' berhasil diperbarui.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AltRule::where('id', $id)->delete();

        return redirect('/' . self::$resource)
        ->with('message', (object) [
            'type' => 'success',
            'content' => self::$title . ' berhasil dihapus.'
        ]);
    }
}
