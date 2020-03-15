@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
           
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    
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
                        <div class="table-responsive">
                         <meta name="csrf-token" content="{{ csrf_token() }}" />
                         <table class="table table-striped table-bordered">
                          <thead>
                           <tr>
                            <th>Title</th>
                            <th>Overview</th>
							<th>Genre</th>
                            <th>Rating</th>
							<th></th>
                           </tr>
						  </thead>
						  <tbody>
						   @if( count( $movies ) > 0 )
							   @foreach($movies as $movie) 
							   <tr>
								<td>{{$movie["title"]}}</td>
								<td>{{$movie["overview"]}}</td>
								<td>@foreach ($movie["genres"] as $key => $value)
										@if( count( $movie["genres"] ) != $key + 1 )
											{{ $value["name"] }}.
										 @else
											{{ $value["name"] }}
										@endif
									@endforeach</td>
								<td>{{$movie["vote_average"]}}</td>
								<td><button class="btn btn-danger" data-id="{{ $movie["id"] }}" data-url="/watch/" onclick="remove_from_watch($(this))">Remove <i class='fa fa-spinner fa-spin' style='display:none;'></i></button></td>
							   </tr>
							   @endforeach
						   @else
						   <tr><td colspan="5" style="text-align:center">No movies to watch.</td></tr>
					       @endif
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
<script type="text/javascript" src="{{ URL::asset('js/user.js') }}"></script>
@endsection
