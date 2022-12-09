<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class CrudController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    //
    $students = app('firebase.firestore')->database()->collection('Clients')->documents();
    return view('Crud/index',compact('students'));
    // return dd($students);
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
    if ($request->doc_id == null) {
      // Uplode Data
      $request->validate([
        'name' => 'required',
        'lastname' => 'required',
        'phone' => 'required',
        'email' => 'required',
        'password' => 'required',
        'sucursal' => 'required',
        'estado' => 'required',
        'folio' => 'required'
       ]);
      $stuRef = app('firebase.firestore')->database()->collection('Clients')->newDocument();
      $stuRef->set([
        'name' => $request->name,
        'lastname' => $request->lastname,
        'phone'    => $request->phone,
        'email'    => $request->email,
        'password'    => $request->password,
        'sucursal'    => $request->sucursal,
        'estado'    => $request->estado,
        'folio'    => $request->folio
      ]);
      Session::flash('message', 'Usuario registrado');
      return back()->withInput();
    }
    else {

      $student = app('firebase.firestore')->database()->collection('Clients')->document($request->doc_id)->snapshot();

      $name = $student->data()['name'];
      $lname = $student->data()['lastname'];
      $phone = $student->data()['phone'];
      $email = $student->data()['email'];
      $pass = $student->data()['password'];
      $sucr = $student->data()['sucursal'];
      $est = $student->data()['estado'];
      $fol = $student->data()['folio'];

      $data = sprintf("Nombre: %s %s \n y Correo: %s", $name, $lname, $email);

      Session::flash('message',  $data);
      return back()->withInput();

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
    echo $id;
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
    //
    $student = app('firebase.firestore')->database()->collection('Clients')->document($id)
   ->update([
    ['path' => 'name', 'value' => $request->name],
    ['path' => 'lastname', 'value' => $request->lastname],
    ['path' => 'phone', 'value' => $request->phone],
    ['path' => 'email', 'value' => $request->email],
    ['path' => 'password', 'value' => $request->password],
    ['path' => 'sucursal', 'value' => $request->sucursal],
    ['path' => 'estado', 'value' => $request->estado],
    ['path' => 'folio', 'value' => $request->folio],
   ]);
   return back();
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    //
    app('firebase.firestore')->database()->collection('Clients')->document($id)->delete();
    return back();
  }
}
