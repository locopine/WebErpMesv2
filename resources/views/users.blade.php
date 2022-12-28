@extends('adminlte::page')

@section('title', 'Users')

@section('content_header')
    <h1>User list</h1>
@stop



@section('content')
    <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
          <div class="table-responsive p-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>E-mail</th>
                  <th>Created</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($Users as $User)
                <tr>
                  <td>{{ $User->name }}</td>
                  <td>{{ $User->email }}</td>
                  <td>{{ $User->GetPrettyCreatedAttribute() }}</td>
                </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                    <th>Name</th>
                    <th>E-mail</th>
                    <th>Created</th>
                  </tr>
              </tfoot>
            </table>
          </div>
          <!-- /.row -->
          <div class="row">
            <div class="col-5">
              {{ $Users->links() }}
            </div>
          </div>
          <!-- /.row -->
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
@stop

@section('css')
@stop

@section('js')
@stop