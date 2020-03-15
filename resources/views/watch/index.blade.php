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
                           </tr>
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
						   </tr>
						   @endforeach
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

@endsection
