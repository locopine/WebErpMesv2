<div class="card-body">
    <div class="card">
        @include('include.search-card')
        <div class="table-responsive p-0">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>
                            <a class="btn btn-secondary" wire:click.prevent="sortBy('orders_id')" role="button" href="#">Order @include('include.sort-icon', ['field' => 'orders_id'])</a>
                        </th>
                        <th>Sort</th>
                        <th>
                            <a class="btn btn-secondary" wire:click.prevent="sortBy('code')" role="button" href="#">Code @include('include.sort-icon', ['field' => 'code'])</a>
                        </th>
                        <th>Product</th>
                        <th>
                            <a class="btn btn-secondary" wire:click.prevent="sortBy('label')" role="button" href="#">Label @include('include.sort-icon', ['field' => 'label'])</a>
                        </th>
                        <th>Qty</th>
                        <th>Unit</th>
                        <th>Selling price</th>
                        <th>Discount</th>
                        <th>VAT type</th>
                        <th>Delivery date</th>
                        <th>Tasks status</th>
                        <th>Delivery status</th>
                        <th>Invoice status</th>
                        <th>Task</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($OrderLineslist as $OrderLine)
                    <tr>
                        <td>
                            <x-OrderButton id="{{ $OrderLine->orders_id }}" code="{{ $OrderLine->order['code'] }}"  />
                        </td>
                        <td>{{ $OrderLine->ordre }}</td>
                        <td>{{ $OrderLine->code }}</td>
                        <td>
                            @if($OrderLine->product_id ) <x-ButtonTextView route="{{ route('products.show', ['id' => $OrderLine->product_id])}}" />@endif
                        </td>
                        <td>{{ $OrderLine->label }}</td>
                        <td>
                            <a href="#" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Delivered qty : {{ $OrderLine->delivered_qty }} <br /> Invoiced qty : {{ $OrderLine->invoiced_qty }}">{{ $OrderLine->qty }}</a>
                        </td>
                        <td>{{ $OrderLine->Unit['label'] }}</td>
                        <td>{{ $OrderLine->selling_price }}</td>
                        <td>{{ $OrderLine->discount }}</td>
                        <td>{{ $OrderLine->VAT['label'] }}</td>
                        <td>{{ $OrderLine->delivery_date }}</td>
                        <td>
                            @if(1 == $OrderLine->tasks_status )  <span class="badge badge-info">No task</span>@endif
                            @if(2 == $OrderLine->tasks_status )  <span class="badge badge-warning">Created</span>@endif
                            @if(3 == $OrderLine->tasks_status )  <span class="badge badge-success">In progress</span>@endif
                            @if(4 == $OrderLine->tasks_status )  <span class="badge badge-danger">Finished (all the tasks are finished)</span>@endif
                        </td>
                        <td>
                            @if(1 == $OrderLine->delivery_status )  <span class="badge badge-info">Not delivered</span>@endif
                            @if(2 == $OrderLine->delivery_status )  <span class="badge badge-warning">Partly delivered</span>@endif
                            @if(3 == $OrderLine->delivery_status )  <span class="badge badge-success">delivered</span>@endif
                        </td>
                        <td>
                            @if(1 == $OrderLine->invoice_status )  <span class="badge badge-info">Not invoiced</span>@endif
                            @if(2 == $OrderLine->invoice_status )  <span class="badge badge-warning">Partly invoiced</span>@endif
                            @if(3 == $OrderLine->invoice_status )  <span class="badge badge-success">Invoiced</span>@endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('task.manage', ['id_type'=> 'order_lines_id', 'id_page'=>  $OrderLine->orders_id, 'id_line' => $OrderLine->id])}}" class="dropdown-item" ><span class="text-success"><i class="fa fa-lg fa-fw  fas fa-list"></i> Tasks ({{  $OrderLine->getTaskCountAttribute() }})</span></a></button>
                            </div>
                        </td>
                        <td>
                            <x-ButtonTextView route="{{ route('orders.show', ['id' => $OrderLine->orders_id])}}" />
                        </td>
                    </tr>
                    @empty
                        <x-EmptyDataLine col="13" text=" No lines found ..."  />
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th>Order</th>
                        <th>Sort</th>
                        <th>External ID</th>
                        <th>Product</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Unit</th>
                        <th>Selling price</th>
                        <th>Discount</th>
                        <th>VAT type</th>
                        <th>Delivery date</th>
                        <th>Tasks status</th>
                        <th>Delivery status</th>
                        <th>Invoice status</th>
                        <th>Task</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.row -->
        {{ $OrderLineslist->links() }}
    <!-- /.card -->
    </div>
<!-- /.card-body -->
</div>