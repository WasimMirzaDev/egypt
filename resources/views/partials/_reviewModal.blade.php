<div id="unworkingModal"  class="modal" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title mb-4">@lang('Share your experience with us'): <span class="extension-name"></span></h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form >

                <div class="modal-body">
                    <div class="form-group mb-3">
                        <div class=" mb-2">
                            <label class="col-md-12 control-label fw-bold">@lang('Rating')</label>
                            <div id="rating_bar">

                                <span class="star1 size" value="1" data-value="1" id="rate_1">&#9733;</span>
                                <span class="star2 size" value="2" data-value="2" id="rate_2">&#9733;</span>
                                <span class="star3 size" value="3" data-value="3" id="rate_3">&#9733;</span>
                                <span class="star4 size" value="4" data-value="4" id="rate_4">&#9733;</span>
                                <span class="star5 size" value="5" data-value="5" id="rate_5">&#9733;</span>
                            </div>
                        </div>
                        <label class="col-md-12 control-label fw-bold">@lang('Description')</label>
                        <div class="col-md-12">
                            <textarea name="script" id="reviewDescription" class="form-control" required rows="6" placeholder="@lang('Please rate us honestly and write your review')">{{ old('script') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button   class="btn btn--primary w-100 h-45" id="submitReview">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>
