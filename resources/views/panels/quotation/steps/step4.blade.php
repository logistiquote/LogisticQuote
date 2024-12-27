<div class="tab-panel" role="tabpanel" id="step4">
    <h4 class="text-center">Other Info</h4>
    <hr>
    <div class="all-info-container">

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="exampleFormControlTextarea1">Remarks</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                          name="remarks">{{ old('remarks') }}</textarea>
                @error('remarks')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="custom-control custom-checkbox">
                    <input type="hidden" name="is_clearance_req" value="0">
                    <input type="checkbox" class="custom-control-input"
                           id="customControlAutosizing3" name="is_clearance_req" value="1">
                    <label class="custom-control-label" for="customControlAutosizing3">
                        Customs Clearance?</label>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="custom-control custom-checkbox">
                    <input type="hidden" name="insurance" value="0">
                    <input type="checkbox" class="custom-control-input"
                           id="customControlAutosizing4" name="insurance" value="1">
                    <label class="custom-control-label" for="customControlAutosizing4">
                        Goods Isurance</label>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleFormControlFile1">Attach a file</label>
                    <input type="file" style="border: 1px solid grey; border-radius: 5px; padding: 10px;" class="form-control-file" name="attachment" id="exampleFormControlFile1">
                </div>
            </div>
        </div>

        <!-- <div class="list-content">
            <a href="#listthree" data-toggle="collapse" aria-expanded="false"
                aria-controls="listthree">Collapse 3 <i class="fa fa-chevron-down"></i></a>
            <div class="collapse" id="listthree">
                <div class="list-box">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name *</label>
                                <input class="form-control" type="text" name="name"
                                    placeholder="">
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Number *</label>
                                <input class="form-control" type="text" name="name"
                                    placeholder="">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div> -->
    </div>

    <ul class="list-inline pull-right">
        <li><button type="button" class="default-btn prev-step">Back</button></li>
        <li><button type="submit" class="default-btn next-step">Request Quotation</button>
        </li>
    </ul>
</div>
