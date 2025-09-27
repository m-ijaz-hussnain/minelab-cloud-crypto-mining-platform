 <!-- Modal -->
 <div class="modal custom--modal fade" id="buyPlanModal" role="dialog">
     <div class="modal-dialog" role="document">
         <div class="modal-content section-bg">
             <div class="modal-header">
                 <h5 class="modal-title">@lang('Buy Mining Plan')</h5>
                 <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <form action="{{ route('user.plan.order') }}" method="POST">
                     @csrf
                     <input name="plan_id" type="hidden">

                     <div class="row gy-4">
                         <div class="text-center">
                             <ul class="list-group">
                                 <li class="list-group-item d-flex justify-content-between flex-wrap">
                                     <span>
                                         <strong>@lang('Title')</strong>
                                     </span>
                                     <span class="plan-title"></span>
                                 </li>
                                 <li class="list-group-item d-flex justify-content-between flex-wrap">
                                     <span>
                                         <strong>@lang('Price')</strong>
                                     </span>
                                     <div>
                                         <span class="plan-price"></span> <span>{{ __(gs('cur_text')) }}</span>
                                     </div>
                                 </li>
                             </ul>
                         </div>

                         <div class="col-sm-12">
                             <label for="paymentMethod">@lang('Payment System')</label>
                             <select class="form--control custom--select" id="paymentMethod" name="payment_method" required>
                                 <option value="" selected disabled>@lang('Select One')</option>
                                 <option value="1">@lang('From Balance')</option>
                                 <option value="2">@lang('Direct Payment')</option>
                             </select>
                         </div>

                         <div class="col-sm-12">
                             <button class="btn--base w-100" type="submit">@lang('Buy Now')</button>
                         </div>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>

 @push('style')
     <style>
         .modal-content {
             text-align: unset !important;
         }

         .custom--modal .list-group-item:last-child {
             border-bottom: 1px solid #ffffff19;
         }
     </style>
 @endpush

 @push('script')
     <script>
         'use strict';
         (function($) {
             $(document).on('click', '.buy-plan', function() {
                 var modal = $('#buyPlanModal');
                 modal.find('input[name=plan_id]').val($(this).data('id'));
                 modal.find('.plan-title').text($(this).data('title'));
                 modal.find('.plan-price').text($(this).data('price'));
                 modal.modal('show');
             });
         })(jQuery);
     </script>
 @endpush
