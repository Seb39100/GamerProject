<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Actualite;
use App\Models\Categorie;
use App\Models\Commentaire;
use Validator;
use Illuminate\Support\Facades\Auth;

class ActualiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lesActualites=Actualite::paginate(20);     
        return view('admin/actualite/index')->with('lesActualites',$lesActualites);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lesCategories = Categorie::pluck('libelle', 'id');
       return view('admin/actualite/create', compact('lesCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titre' => 'required|max:255',
            'description' => 'required|max:65532',  
            'categorie' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('admin/actualite/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        else
        {
            $uneActualite= new Actualite();
            $uneActualite->titre=$request->get('titre');
            $uneActualite->description=$request->get('description');
            $uneActualite->categorie()->associate($request->get('categorie'));
            //dd($request->get('categorie'));
            $uneActualite->user_id = (Auth::user()->id);
            $uneActualite->save();
            $request->session()->flash('success', "L'actualité a été créée.");
            return redirect (route('actualite.index'));
        }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $uneActualite=Actualite::find($id);
        return view ('admin/actualite/show')->with('uneActualite',$uneActualite);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $uneActualite=Actualite::find($id);
       $lesCategories = Categorie::pluck('libelle', 'id');
        return view('admin/actualite/edit', compact('uneActualite', 'lesCategories'));
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
         $validator = Validator::make($request->all(), [
            'titre' => 'required|max:255',
            'description' => 'required|max:65532',
             'categorie' => 'required',
           
        ]);

        if ($validator->fails()) {
            return (route('actualite.edit', $id)
                        ->withErrors($validator)
                        ->withInput()
                    );
        }
        else
        {
            $uneActualite=Actualite::find($id);
            $uneActualite->titre=$request->get('titre');
            $uneActualite->description=$request->get('description');
            $uneActualite->categorie()->associate($request->get('categorie'));
            $uneActualite->update();
            $request->session()->flash('success', "L'actualité a été modifiée.");
            return redirect (route('actualite.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        Actualite::destroy($id);
        $request->session()->flash('success', "L'actualité a été supprimée.");
        return redirect (route('actualite.index'));
    }
      
    
    public function indexFront()
    {
        $lesActus = Actualite::orderBy('id', 'desc')->paginate(20);
        return view ('front/actualite/index', compact('lesActus'));
    }
    
    public function showFront($id)
    {
        
        $uneActu = Actualite::find($id);
        $lesCom = Commentaire::where('actualite_id', $id)->orderBy('id', 'desc')->paginate(15);
    
         
        return view ('front/actualite/show', compact('uneActu', 'lesCom'));
    }
}
