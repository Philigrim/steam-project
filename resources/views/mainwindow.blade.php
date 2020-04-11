@extends('layouts.app', ['title' => __('Naujienos')])

@section('additional_header_content')

{{--Search--}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

@endsection

@section('content')
@include('users.partials.header', ['title' => __('Naujienos'),
         'description' => __('Šiame puslapyje skelbiama informacija apie STEAM centrus bei kitos naujienos.')])

@if (session('status'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('status') }}

    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="row">

    <div class="col-xl-7 ml-5 mt-3">

    <div clas="row">

    <!-- Search form -->
    <div class="container box">
        <h3 align="center">Live search in laravel using AJAX</h3><br />
        <div class="panel panel-default">
         <div class="panel-heading">Search Customer Data</div>
         <div class="panel-body">
          <div class="form-group">
           <input type="text" name="search" id="search" class="form-control" placeholder="Search Customer Data" />
          </div>
          <div class="table-responsive">
           <h3 align="center">Total Data : <span id="total_records"></span></h3>
           <table class="table table-striped table-bordered">
            <thead>
             <tr>
              <th>Title</th>
              <th>Text</th>
             </tr>
            </thead>
            <tbody>
     
            </tbody>
           </table>
          </div>
         </div>    
        </div>
    </div>

    </div>

    <!-- /Announcements -->
    
    </div>

    <div class="border-right mt-3 ml-5 mb-2 d-flex justify-content-center"></div>

    <!-- Promoted Courses (right side)-->
    <div class="col-xl-4 ml-5">
        <div class="card card-stats mt-3 d-flex justify-content-center">
            <div class="card-body border border-primary rounded">
                
                <div class="border-top mt-2 mb-2"></div>

                <h1 class="card-title font-weight-bold d-flex justify-content-center"> TEST Promoted course title #1 </h1>
                
                <div class="border-top mt-2 mb-2"></div>

                <div class="ml-2"> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. </div>

                

                <div class="border-top mt-2 mb-2"></div>
                <span class="ml-2">Lecturer:</span>
                <span class="ml-2"> LecturerFirstName LecturerLastName </span>
                <div class="border-top mt-2 mb-2"></div>
                <button type = "submit" class = "btn btn-success float-right">
                Registruotis
                </button>
                </a>   
            </div>
        </div>

        <div class="card card-stats mt-3 d-flex justify-content-center">
            <div class="card-body border border-primary rounded">
                
                <div class="border-top mt-2 mb-2"></div>

                <h1 class="card-title font-weight-bold d-flex justify-content-center"> TEST Promoted course title #2 </h1>
                
                <div class="border-top mt-2 mb-2"></div>

                <div class="ml-2"> It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like). </div>

                

                <div class="border-top mt-2 mb-2"></div>
                <span class="ml-2">Lecturer:</span>
                <span class="ml-2"> LecturerFirstName LecturerLastName </span>
                <div class="border-top mt-2 mb-2"></div>
                <button type = "submit" class = "btn btn-success float-right">
                Registruotis
                </button>
                </a>   
            </div>
        </div>

        <div class="card card-stats mt-3 d-flex justify-content-center">
            <div class="card-body border border-primary rounded">
                
                <div class="border-top mt-2 mb-2"></div>

                <h1 class="card-title font-weight-bold d-flex justify-content-center"> TEST Promoted course title #3 </h1>
                
                <div class="border-top mt-2 mb-2"></div>

                <div class="ml-2"> TEST Promoted course text/info </div>

                

                <div class="border-top mt-2 mb-2"></div>
                <span class="ml-2">Lecturer:</span>
                <span class="ml-2"> TEST TEST </span>
                <div class="border-top mt-2 mb-2"></div>
                <button type = "submit" class = "btn btn-success float-right">
                Registruotis
                </button>
                </a>   
            </div>
        </div>
    </div>
    <!-- /Promoted Courses (right side) -->

</div>

<script>
$(document).ready(function(){

    fetch_customer_data();
   
    function fetch_customer_data(query = '')
    {
     $.ajax({
      url:"{{ route('home.action') }}",
      method:'GET',
      data:{query:query},
      dataType:'json',
      success:function(data)
      {
       $('tbody').html(data.table_data);
       $('#total_records').text(data.total_data);
      }
     })
    }
   
    $(document).on('keyup', '#search', function(){
     var query = $(this).val();
     fetch_customer_data(query);
    });
   }); 
</script>  
@include('layouts.footers.auth')
@endsection
