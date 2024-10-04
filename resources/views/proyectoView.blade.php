@extends('layouts.app')

@section('content')

<article class="m-4">
  <div class="container px-4 px-lg-5">
    <div class="row gx-4 gx-lg-5 justify-conten-center">
      <div class="col-md-10 col-lg-8 col-xl-7">
        {!!$proyecto->descripcion!!}
      </div>
      <div class="col-md-10 col-lg-8 col-xl-7">
      <h2>Imagen del proyecto</h2>
        <div class="col-4 p4">
          p)
          <img src="{{asset('assets/img/$proyecto->portada)}}" alt="" class="img-fluid">
          
        </div>
      </div>
    </div>
  </div>
</article>

@endsection

section('scripts')



@endsection