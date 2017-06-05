@extends('app')

@section('content')
    <h1>Investments</h1>
    <a href="{{url('/investments/create')}}" class="btn btn-success">Create Investments</a>
    <hr>
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr class="bg-info">
            <th>Cust Number</th>
            <th>Cust Name</th>
            <th>Category</th>
            <th>Description</th>
            <th>Acquired Value</th>
            <th>Acquired Date</th>
            <th>Recent Value</th>
            <th>Recent date</th>
            <th colspan="3">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($investments as $investment)
            <tr>
                <td>{{ $investment->customer->cust_number }}</td>
                <td>{{ $investment->customer->name }}</td>
                <td>{{ $investment->category }}</td>
                <td>{{ $investment->desccription }}</td>
                <td>{{ $investment->acquired_value }}</td>
                <td>{{ $investment->acquired_date }}</td>
                <td>{{ $investment->recent_value }}</td>
                <td>{{ $investment->recent_date }}</td>
                <td><a href="{{url('investments',$investment->id)}}" class="btn btn-primary">Read</a></td>
                <td><a href="{{route('investments.edit',$investment->id)}}" class="btn btn-warning">Update</a></td>
                <td>
                    {!! Form::open(['method' => 'DELETE', 'route'=>['investments.destroy', $investment->id]]) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger','onClick'=> 'return confirm("Are you sure?")']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach

        </tbody>

    </table>
@endsection

