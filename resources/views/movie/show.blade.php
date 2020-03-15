@extends('layouts.app')

@section('content')
	<div class="container">
       		{{ $movie->resource["title"]}} <br /><br /> 
		{{ $movie->resource["overview"]}} <br /> <br />
	</div>
@endsection
