@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
    {{-- @foreach ($courses as $course)
    <tr>
    <td>{{ $course->course_title }}</td>
    </tr>
    @endforeach --}}
    @foreach ($courses as $course)
    <tr>
    
    <div class="card card-stats mt-3">
          <div class="card-body border border-primary rounded">
          
                <div class="col">
                    <h1>
                    <span class="h2 font-weight-bold mb-0 d-flex justify-content-center"><td>{{ $course->course_title }}</td></span>
                    </h1>
                </div>

           <div class="row ml-2 mt-3">   
                <p class="mb-0 text-muted text-sm">
                    <h3>
                    <span class="text-nowrap ">
                        
                            Aprašymas:
                                      
                    </span> 
                    </h3>
               </p>
                <div class = "">     
                    <td>
                            {{ $course->description }}
                    </td>
                </div> 
            </div>

            <div class="d-flex flex-row ml-2 mt-3 mt">
               <div class="mb-0 text-muted text-sm">
                    <h3>Dėstytojas: </h3>              
               </div>
                <div class = "ml-3">     
                            {{ $course->lecturer_name }} {{ $course->lecturer_last_name }}
                </div>
                
            </div> 
<div class="text-center ">
                    <button type="submit" class="btn btn-primary my-4">Registruotis</button>
                </div>
            
    </div>


    </tr>



    
    @endforeach
@endsection
