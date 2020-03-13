@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
           
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <div class="form-group">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Search Titles" />
                    </div>
                    <div id="loader" style="display: none;
                                            position: fixed;
                                            top: 0;
                                            left: 0;
                                            right: 0;
                                            bottom: 0;
                                            width: 100%;
                                            background: rgba(0,0,0,0.75) url(/loading.gif) no-repeat center center;
                                            z-index: 10000;"> 
                    </div>
                    <div id='table-data'>
                        <h3 >Total Data : <span id="total_records"></span></h3>
                        <div class="paging"></div>
                        <div class="table-responsive">
                         <meta name="csrf-token" content="{{ csrf_token() }}" />
                         <table class="table table-striped table-bordered">
                          <thead>
                           <tr>
                            <th>Title</th>
                            <th>Overview</th>
                            <th>Rating</th>
                            <th>Watch</th>
                           </tr>
                          </thead>
                          <tbody>
                   
                          </tbody>
                         </table>
                        </div>
                        <div class="paging"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){

 fetch_movies();

 function fetch_movies(query = '', page=1)
 {

  $("#loader").show();
  $("#table-data").hide();
  
  $.ajax({
   url:"{{ route('movies.index') }}",
   method:'GET',
   data:{query:query.split('&')[0],page:page},
   dataType:'json',
   success:function(data)
   {

   
    var c = [];
    
    $.each(data.data, function(i, item) {
        
        var tr = "<tr>"+
                  "<td>" + item.title + "</td>" +
                  "<td>" + item.overview + "</td>" +
                  "<td>" + item.vote_average + "</td>";
                  
        var user_movies = @json($movies);
        
        if(user_movies.includes(item.id))
        {
            tr += "<td><button data-id='" + item.id + "' data-url='" + "/watch/" + "' class='btn btn-danger unwatch'>Remove</button></td>";
        }               
        else
        {
            tr +=  "<td><button data-id='" + item.id + "' class='btn btn-info watch-list'>Add</button></td>";
        }
    
        tr += "</tr>";
        
        c.push(tr);
        
        $("#loader").hide();
        $("#table-data").show();
    });
    
    $('tbody').html(c.join(""));
    $('#total_records').text(data.meta.total);
    $('.paging').html(data.links[Object.keys(data.links)[0]]);
    
     $(".watch-list").click(function(){
       $.ajax({
        url:"/watch",
        method:'POST',
        data: {
                'movie_id': $(this).attr("data-id"),
                '_token': $('meta[name="csrf-token"]').attr('content'),
              },
        dataType:'json',
        success:function(data)
        {

        }
       });
       
     }); 

     $(".unwatch").click(function(){
       $.ajax({
        url: $(this).attr("data-url") + $(this).attr("data-id"),
        method:'DELETE',
        data: {
                'movie_id': $(this).attr("data-id"),
                '_token': $('meta[name="csrf-token"]').attr('content'),
              },
        dataType:'json',
        success:function(data)
        {
              console.log(data);
        }
       });
     }); 
     
   }
  })
 }

 $(document).on('keyup', '#search', function(){
  var query = $(this).val();
  if(query.length > 3)
  {
    fetch_movies(query);
  }
 });
 
 $(document).on('click', '.pagination a', function(event){
  event.preventDefault(); 
  var page = $(this).attr('href').split('page=')[1];

  var query = $(this).attr('href').split('query=')[1];

  fetch_movies(query,page);
 });


});
</script>
@endsection
