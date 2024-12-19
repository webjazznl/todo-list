@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Taken</h1>
  <a href="{{ route('tasks.create') }}" class="btn btn-primary">Nieuwe Taak</a>
  <table class="table mt-3">
    <thead>
      <tr>
        <th>Taak</th>
        <th>Start</th>
        <th>Einde</th>
        <th>Gereed</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($tasks as $task)
      <tr>
        <td>{{ $task->title }}</td>
        <td>{{ date('d-m-Y', strtotime($task->start_date)) }}</td>
        <td>{{ date('d-m-Y', strtotime($task->end_date)) }}</td>
        <td>{{ $task->completed ? 'Ja' : 'Nee' }}</td>
        <td>
          @if(!$task->completed)
          <form action="{{ route('tasks.completed', $task->id) }}" method="POST" style="display:inline-block;">
            @csrf
            <button type="submit" class="btn btn-success btn-sm" id="click-me">Gereed</i></a></button>
          </form>
          <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm">Bewerk</a>
          @endif
          <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">Verwijder</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection