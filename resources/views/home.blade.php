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
                    
                    <div class="form-group">
						<input type="hidden" name="user_movies" id="user-movies" value="@json($movies)" />
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
							<th></th>
                            <th>Title</th>
                            <th>Overview</th>
							<th>Genre</th>
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

<script type="text/javascript" src="{{ URL::asset('js/custom.js') }}"></script>
@endsection
