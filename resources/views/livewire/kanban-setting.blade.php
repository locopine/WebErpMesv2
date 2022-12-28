
<div>
    <div class="card">
        <div class="card-body">
            @include('include.alert-result')
            <form wire:submit.prevent="storeKanbanStatuLine">
                <div class="row">
                    <div class="col-4">
                        <label for="title">Title</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-ruler"></i></span>
                            </div>
                            <select class="form-control @error('title') is-invalid @enderror" name="title" id="title"  wire:model="title">
                                <option value="" selected>Select type</option>
                                <option value="Open" >Open</option>
                                <option value="Started" >Started</option>
                                <option value="In progress" >In progress</option>
                                <option value="Finished" >Finished</option>
                                <option value="Suspended" >Suspended</option>
                                <option value="To RFQ" >To RFQ</option>
                                <option value="RFQ in progress" >RFQ in progress</option>
                                <option value="Outsourced" >Outsourced</option>
                                <option value="Supplied" >Supplied</option>
                            </select>
                        </div>
                        @error('title') <span class="text-danger">{{ $message }}<br/></span>@enderror
                    </div>
                    <div class="col-4">
                        <label for="label">Order :</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-tags"></i></span>
                            </div>
                            <input type="number" class="form-control @error('order') is-invalid @enderror" id="order" placeholder="Order" wire:model="order">
                        </div>
                        @error('order') <span class="text-danger">{{ $message }}<br/></span>@enderror
                    </div>
                    <div class="col-2">
                        <br/>
                        <button type="submit" class="btn btn-success btn-block">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Order</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($KanbanSettingViewLines as $KanbanSettingViewLine)
                        <tr>
                            <td>{{ $KanbanSettingViewLine->title }}</td>
                            <td>{{ $KanbanSettingViewLine->order }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="#" wire:click="destroyKanban({{ $KanbanSettingViewLine->id }})" class="btn btn-danger"><i class="fa fa-lg fa-fw fa-trash"></i></a>
                                </div>
                                <div class="btn-group btn-group-sm">
                                    <a href="#" wire:click="upKanban({{ $KanbanSettingViewLine->id }})" class="btn btn-secondary"><i class="fa fa-lg fa-fw  fa-sort-amount-down"></i></a>
                                </div>
                                <div class="btn-group btn-group-sm">
                                    <a href="#" wire:click="downKanban({{ $KanbanSettingViewLine->id }})" class="btn btn-primary"><i class="fa fa-lg fa-fw  fa-sort-amount-up-alt"></i></a>
                                </div>
                            </td>
                        </tr>
                        @empty
                            <x-EmptyDataLine col="3" text="No line found ..."  />
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Description</th>
                            <th>Order</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
