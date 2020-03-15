$(document).ready(function(){

 fetch_movies($('#user-movies').val());

 function fetch_movies(user_movies, query = '', page=1)
 {

  $("#loader").show();
  $("#table-data").hide();
  
  $.ajax({
   url:"/movies/",
   method:'GET',
   data:{query:query.split('&')[0],page:page},
   dataType:'json',
   success:function(data)
   {

   
    var c = [];
    
    $.each(data.data, function(i, item) {
        
        var tr = "<tr>"+
				  "<td style='text-align:center; vertical-align:middle;'><img width='50%' height='50%' src='https://image.tmdb.org/t/p/original/" + item.poster_path + "'</img></td>" +
                  "<td>" + item.title + "</td>" +
                  "<td>" + item.overview + "</td>" +
				  "<td>" + item.genres + "</td>" +
                  "<td>" + item.vote_average + "</td>";
        
        if(user_movies.includes(item.id))
        {
            tr += "<td><button data-id='" + item.id + "' data-url='" + "/watch/" + "' class='btn btn-danger unwatch'>Remove <i class='fa fa-spinner fa-spin' style='display:none;'></i></button></td>";
        }               
        else
        {
            tr +=  "<td><button data-id='" + item.id + "' class='btn btn-info watch-list'>Add <i class='fa fa-spinner fa-spin' style='display:none;'></i></button></td>";
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
	   var btn = $(this);
	   btn.attr("disabled", true);
	   btn.find("i").show();
	   var movie_id = $(this).attr("data-id");

       $.ajax({
        url:"/watch",
        method:'POST',
        data: {
                'movie_id': movie_id,
                '_token': $('meta[name="csrf-token"]').attr('content'),
              },
        dataType:'json',
        success:function(data)
        {
			var user_movies =  JSON.parse($('#user-movies').val());
			user_movies.push(parseInt(movie_id));
			$('#user-movies').val("[" + user_movies + "]");
			btn.find("i").hide();
			btn.attr("disabled", false);
			fetch_movies(user_movies,query,page);
        }
       });
       
     }); 

     $(".unwatch").click(function(){
	   var btn = $(this);
	   btn.attr("disabled", true);
	   btn.find("i").show();
	   
	   var user_movies =  JSON.parse($('#user-movies').val());
	   var movie_id = $(this).attr("data-id");
	   
       $.ajax({
        url: $(this).attr("data-url") + $(this).attr("data-id"),
        method:'DELETE',
        data: {
                'movie_id': movie_id,
                '_token': $('meta[name="csrf-token"]').attr('content'),
              },
        dataType:'json',
        success:function(data)
        {
			  btn.find("i").hide();
			  btn.attr("disabled", false);

			  for( var i = 0; i < user_movies.length; i++)
			  { 
					if ( user_movies[i] == movie_id) 
					{ 
						user_movies.splice(i, 1); 
					}
			  }
			  
			  $('#user-movies').val("[" + user_movies + "]");
              fetch_movies(user_movies,query, page);
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
    fetch_movies($('#user-movies').val(),query);
  }
 });
 
 $(document).on('click', '.pagination a', function(event){
  event.preventDefault(); 
  var page = $(this).attr('href').split('page=')[1];

  var query = $(this).attr('href').split('query=')[1];

  fetch_movies($('#user-movies').val(),query,page);
 });


});