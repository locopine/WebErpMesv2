@extends('adminlte::page')

@section('title', 'Quote')

@section('content_header')
  <x-Content-header-previous-button  h1="Quote : {{  $Quote->code }}" previous="{{ $previousUrl }}" list="{{ route('quotes') }}" next="{{ $nextUrl }}"/>
@stop

@section('right-sidebar')

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<div class="card">
  <div class="card-header p-2">
    <ul class="nav nav-pills">
      <li class="nav-item"><a class="nav-link active" href="#Quote" data-toggle="tab">Quote info</a></li>
      <li class="nav-item"><a class="nav-link" href="#Lines" data-toggle="tab">Quote lines</a></li>
    </ul>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <div class="tab-content">
      <div class="tab-pane active" id="Quote">
        <div class="row">
          <div class="col-md-9">
            @include('include.alert-result')
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"> Informations </h3>
              </div>
              <form method="POST" action="{{ route('quotes.update', ['id' => $Quote->id]) }}" enctype="multipart/form-data">
                @csrf 
                <div class="card card-body">
                  <div class="row">
                      <div class="col-3">
                        <label for="code" class="text-success">External ID :</label>  {{  $Quote->code }}
                      </div>
                      <div class="col-3">
                        <x-adminlte-select name="statu" label="Statu" label-class="text-success" igroup-size="sm">
                          <x-slot name="prependSlot">
                              <div class="input-group-text bg-gradient-success">
                                  <i class="fas fa-exclamation"></i>
                              </div>
                          </x-slot>
                          <option value="1" @if(1 == $Quote->statu ) Selected @endif >Open</option>
                          <option value="2" @if(2 == $Quote->statu ) Selected @endif >Send</option>
                          <option value="3" @if(3 == $Quote->statu ) Selected @endif >Win</option>
                          <option value="4" @if(4 == $Quote->statu ) Selected @endif >Lost</option>
                          <option value="5" @if(5 == $Quote->statu ) Selected @endif >Closed</option>
                          <option value="6" @if(6 == $Quote->statu ) Selected @endif >Obsolete</option>
                        </x-adminlte-select>
                      </div>
                      <div class="col-3">
                        @include('include.form.form-input-label',['label' =>'Name of quote', 'Value' =>  $Quote->label])
                      </div>
                    </div>
                  </div>
                  <div class="card card-body">
                    <div class="row">
                      <label for="InputWebSite" class="text-info">Customer information</label>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-5">
                        @include('include.form.form-select-companie',['companiesId' =>  $Quote->companies_id])
                      </div>
                      <div class="col-5">
                        @include('include.form.form-input-customerInfo',['customerReference' =>  $Quote->customer_reference])
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-5">
                        @include('include.form.form-select-adress',['adressId' =>   $Quote->companies_addresses_id])
                      </div>
                      <div class="col-5">
                        @include('include.form.form-select-contact',['contactId' =>   $Quote->companies_contacts_id])
                      </div>
                    </div>
                  </div>
                  <div class="card card-body">
                    <div class="row">
                      <label for="InputWebSite">Date & Payment information</label>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-5">
                        @include('include.form.form-select-paymentCondition',['accountingPaymentConditionsId' =>   $Quote->accounting_payment_conditions_id])
                      </div>
                      <div class="col-5">
                          @include('include.form.form-select-paymentMethods',['accountingPaymentMethodsId' =>   $Quote->accounting_payment_methods_id])
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-5">
                          @include('include.form.form-select-delivery',['accountingDeliveriesId' =>   $Quote->accounting_deliveries_id])
                      </div>
                      <div class="col-5">
                        <label for="label">Validity date</label>
                        <div class="input-group">
                          <div class="input-group-text bg-gradient-secondary">
                            <i class="fas fa-calendar-day"></i>
                          </div>
                          <input type="date" class="form-control" name="validity_date"  id="validity_date" value="{{  $Quote->validity_date }}">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card card-body">
                    <div class="row">
                      <x-FormTextareaComment  comment="{{ $Quote->comment }}" />
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="Submit" class="btn btn-primary">Save changes</button>
                  </div>
              </form>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title"> Informations </h3>
              </div>
              <div class="card-body">
                @include('include.sub-total-price')
              </div>
            </div>
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title"> Options </h3>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <tr>
                        <td style="width:50%"> <x-ButtonTextPrint route="{{ route('print.quote', ['Document' => $Quote->id])}}" /></td>
                        <td><x-ButtonTextPDF route="{{ route('pdf.quote', ['Document' => $Quote->id])}}" /></td>
                    </tr>
                </table>
              </div>
            </div>
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title"> Documents </h3>
              </div>
                <div class="card-body">
                    <form action="{{ route('file.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa-file"></i></span>
                            </div>
                            <div class="custom-file">
                              <input type="hidden" name="quote_id" value="{{ $Quote->id }}" >
                              <input type="file" name="file" class="custom-file-input" id="chooseFile">
                              <label class="custom-file-label" for="chooseFile">Choose file</label>
                            </div>
                            <div class="input-group-append">
                              <button type="submit" name="submit" class="btn btn-success">
                                Upload
                              </button>
                            </div>
                          </div>
                    </form>
                    <h5 class="mt-5 text-muted">Attached files</h5>
                    <ul class="list-unstyled">
                      @forelse ( $Quote->files as $file)
                      <li>
                        <a href="{{ asset('/file/'. $file->name) }}" download="{{ $file->original_file_name }}" class="btn-link text-secondary">{{ $file->original_file_name }} -  <small>{{ $file->GetPrettySize() }}</small></a>
                      </li>
                      @empty
                        No file
                      @endforelse
                    </ul>
              </div>
            </div>
          </div>
        </div>
      </div>   
      <div class="tab-pane " id="Lines">
        @livewire('quote-line', ['QuoteId' => $Quote->id, 'QuoteStatu' => $Quote->statu, 'QuoteDelay' => $Quote->validity_date])
      </div>           
  </div>
  <!-- /.card-body -->
</div>
<!-- /.card -->

@stop

@section('css')
@stop

@section('js')
@stop