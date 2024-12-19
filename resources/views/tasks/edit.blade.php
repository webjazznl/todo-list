@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Bewerk Taak</h1>
  <form action="{{ route('tasks.update', $task->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
      <label for="title" class="form-label">Taak</label>
      <input type="text" name="title" id="title" class="form-control" value="{{ old('title') ?? $task->title }}" required>
    </div>
    <div class="mb-3">
      <label for="start_date" class="form-label">Start</label>
      <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') ??  $task->start_date }}">
    </div>
    <div class="mb-3">
      <label for="end_date" class="form-label">Einde</label>
      <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date') ?? $task->end_date }}">
      @error('end_date')
      <div class="text-danger">{{ $message }}</div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="description" class="form-label">
        <textarea name="description" id="description" class="form-control">{{ old('description') ?? $task->description }}</textarea>
    </div>
    <button type="submit" class="btn btn-primary">Update Task</button>
  </form>
</div>
@endsection