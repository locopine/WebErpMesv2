<div class="modal fade" id="BOMModal{{ $id_line }}" tabindex="-1" role="dialog" aria-labelledby="BOMModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <form method="POST" action="{{ $route }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-3">
                <label for="ORDER">Sort order</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-sort-numeric-down"></i></span>
                  </div>
                  <input type="number" class="form-control" name="ORDER" id="ORDER" placeholder="Order">
                  <input type="hidden" class="form-control" name="{{ $id_type }}" value="{{ $id_line }}">
                </div>
              </div>
              <div class="col-3">
                  <label for="methods_services_id">Services</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-list"></i></span>
                    </div>
                    <select class="methods_services_id form-control" name="methods_services_id" id="methods_services_id_BOM_{{ $id_line }}">
                      <option>Select Services</option>
                      @foreach ($BOMServicesSelect as $item)
                      <option value="{{ $item->id }}"  class="{{ $item->id }}" data-type-{{ $id_line }}="{{ $item->TYPE }}" data-txt-{{ $id_line }}="{{ $item->LABEL }}">{{ $item->CODE }}</option>
                      @endforeach
                    </select>
                    <!-- script or change label -->
                    <script>
                      $("#methods_services_id_BOM_" + {{ $id_line }}).on('change',function(){
                        var val = $(this).val();
                        var txt = $(this).find('option:selected').data("txt-" + {{ $id_line }});
                        var type = $(this).find('option:selected').data("type-" + {{ $id_line }});
                        $("#LABEL_BOM_" + {{ $id_line }}).val( txt );
                        $("#TYPE_BOM_" + {{ $id_line }}).val( type );
                    });
                    
                    $("#methods_services_id_BOM_" + {{ $id_line }}).change(function () {
                        var modelObj = $(this).parent().next().children(".component_id_" + {{ $id_line }});
                        var selector = "option[class="+this.value.toLowerCase()+"]";
                        modelObj.children(":not("+selector+")").hide();
                        modelObj.children(selector).show();
                    });
                    </script>
                    <!-- end -->
                    <input type="hidden" class="form-control" name="TYPE" id="TYPE_BOM_{{ $id_line }}">
                  </div>
              </div>
              <div class="col-3">
                <label for="component_id">Component</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                  </div>
                  <select class="component_id form-control" name="component_id" id="component_id_{{ $id_line }}"">
                    <option>Select Component</option>
                    @foreach ($ProductSelect as $item)
                    <option value="{{ $item->id }}" class="{{ $item->methods_services_id }}">{{ $item->CODE }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-3">
                  <label for="LABEL">Label</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-tags"></i></span>
                    </div>
                    <input type="text" class="form-control" name="LABEL"  id="LABEL_BOM_{{ $id_line }}" placeholder="Label">
                  </div>
              </div>
            </div>
            <div class="row">
              <div class="col-3">
                <label for="QTY">Quantity</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-times"></i></span>
                  </div>
                 <input type="number" class="form-control" name="QTY"  id="QTY" placeholder="Quantity" step=".001">
                </div>
              </div>
              <div class="col-3">
                <label for="UNIT_COST">Unit cost</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                      <span class="input-group-text">{{ $Factory->curency }}</span>
                  </div>
                  <input type="number" class="form-control" name="UNIT_COST"  id="UNIT_COST" placeholder="Unit cost" step=".001">
                </div>
              </div>
              <div class="col-3">
                <label for="UNIT_PRICE">Unit price</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                      <span class="input-group-text">{{ $Factory->curency }}</span>
                  </div>
                  <input type="number" class="form-control" name="UNIT_PRICE"  id="UNIT_PRICE" placeholder="Unit time" step=".001">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="Submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>