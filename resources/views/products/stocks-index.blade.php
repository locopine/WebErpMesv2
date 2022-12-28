@extends('adminlte::page')

@section('title', 'Stock')

@section('content_header')
    <h1>Stock</h1>
@stop

@section('right-sidebar')

@section('content')

                <div class="card">
                  @include('include.alert-result')
                    <div class="card card-primary">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-6 card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Stocks list</h3>
                            </div>
                            <div class="card-body table-responsive p-0">
                              <table class="table table-hover">
                                <thead>
                                  <tr>
                                    <th>External ID</th>
                                    <th>Desciption</th>
                                    <th>Lines count</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @forelse ($stocks as $stock)
                                  <tr>
                                    <td>{{ $stock->code }}</td>
                                    <td>{{ $stock->label }}</td>
                                    <td>{{ $stock->stock_location_count }}</td>
                                    
                                    <td>{{ $stock->GetPrettyCreatedAttribute() }}</td>
                                    <td class="py-0 align-middle">
                                      <div class="btn-group btn-group-sm">
                                        <a href="{{ route('products.stock.show', ['id' => $stock->id])}}" class="btn bg-primary"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                                      </div>
                                      <!-- Button Modal -->
                                      <button type="button" class="btn bg-teal" data-toggle="modal" data-target="#StockModal{{ $stock->id }}">
                                        <i class="fa fa-lg fa-fw  fa-edit"></i>
                                      </button>
                                      <!-- Modal {{ $stock->id }} -->
                                      <x-adminlte-modal id="StockModal{{ $stock->id }}" title="Update {{ $stock->label }}" theme="teal" icon="fa fa-pen" size='lg' disable-animations>
                                        <form method="POST" action="{{ route('products.stock.update', ['id' => $stock->id]) }}" >
                                          @csrf
                                          <div class="card-body">
                                            <div class="form-group">
                                              <label for="label">Label</label>
                                              <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-tags"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="label"  id="label" placeholder="Label" value="{{ $stock->label }}">
                                              </div>
                                            </div>
                                            <div class="form-group">
                                              <label for="service_id">User management</label>
                                              <div class="input-group">
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text"><i class="fas fa-list"></i></span>
                                                </div>
                                                  <select class="form-control" name="user_id" id="user_id">
                                                    @foreach ($userSelect as $item)
                                                    <option value="{{ $item->id }}" @if($stock->user_id == $item->id  ) Selected @endif>{{ $item->name }}</option>
                                                    @endforeach
                                                  </select>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="card-footer">
                                            <x-adminlte-button class="btn-flat" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save"/>
                                          </div>
                                        </form>
                                      </x-adminlte-modal>
                                    </td>
                                  </tr>
                                  @empty
                                  <x-EmptyDataLine col="4" text="No lines found ..."  />
                                  @endforelse
                                </tbody>
                                <tfoot>
                                  <tr>
                                    <th>External ID</th>
                                    <th>Desciption</th>
                                    <th>Lines count</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                  </tr>
                                </tfoot>
                              </table>
                            </div>
                          <!-- /.card secondary -->
                          </div>
            
                          <div class="col-md-6 card-secondary">
                              <div class="card-header">
                                <h3 class="card-title">New Stock</h3>
                              </div>
                              <div class="card-body">
                                <form  method="POST" action="{{ route('products.stock.store') }}" class="form-horizontal">
                                  @csrf
                                  <div class="form-group">
                                    <label for="code">External ID</label>
                                    <div class="input-group">
                                      <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="fas fa-external-link-square-alt"></i></span>
                                      </div>
                                      <input type="text" class="form-control" name="code" id="code" placeholder="External ID" value="STOCK-{{ $LastStock->id ?? '0' }}">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="label">Description</label>
                                    <div class="input-group">
                                      <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="fas fa-tags"></i></span>
                                      </div>
                                      <input type="text" class="form-control" name="label" id="label" placeholder="Description">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="user_id">User management</label>
                                    <div class="input-group">
                                      <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                      </div>
                                      <select class="form-control" name="user_id" id="user_id">
                                        @foreach ($userSelect as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                  </div>
                                  <div class="card-footer">
                                    <div class="offset-sm-2 col-sm-10">
                                      <button type="submit" class="btn btn-danger">Submit New</button>
                                    </div>
                                  </div>
                                </form>
                              <!-- /.card body -->
                              </div>
                            <!-- /.card secondary -->
                            </div>
                          <!-- /.row -->
                          </div>
                        <!-- /.card body -->
                        </div>
                      <!-- /.card primary -->
                      </div>
                    <!-- /.card --> 
                    </div>
@stop

@section('css')
@stop

@section('js')

@stop