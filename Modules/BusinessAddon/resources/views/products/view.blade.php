<div class="modal fade p-0" id="product-view">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">{{ __('View') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body order-form-section">
                <div class="costing-list">
                    <ul>
                        <div class="row mt-2"><div class="col-5">{{ __('Product Image') }}</div> <div class="col-1">:</div> <div class="col-6"> <img class="table-img"
                                 src="" alt="" id="product_image"></div></div>
                        <div class="row mt-2"><div class="col-5">{{ __('Product Name') }}</div> <div class="col-1">:</div> <div class="col-6" id="product_name"></div></div>
                        <div class="row mt-2"><div class="col-5">{{ __('Code') }}</div> <div class="col-1">:</div> <div class="col-6" id="product_code"></div></div>
                        <div class="row mt-2"><div class="col-5">{{ __('Brand') }}</div> <div class="col-1">:</div> <div class="col-6" id="product_brand"></div></div>
                        <div class="row mt-2"><div class="col-5">{{ __('Category') }}</div> <div class="col-1">:</div> <div class="col-6" id="product_category"></div></div>
                        <div class="row mt-2"><div class="col-5">{{ __('Unit') }}</div> <div class="col-1">:</div> <div class="col-6" id="product_unit"></div></div>
                        <div class="row mt-2"><div class="col-5">{{ __('Purchase price') }}</div> <div class="col-1">:</div> <div class="col-6"
                                id="product_purchase_price"></div></div>
                        <div class="row mt-2"><div class="col-5">{{ __('Sale price') }}</div> <div class="col-1">:</div> <div class="col-6" id="product_sale_price"></div>
                        </div>
                        <div class="row mt-2"><div class="col-5">{{ __('Wholesale Price') }}</div> <div class="col-1">:</div> <div class="col-6"
                                id="product_wholesale_price"></div></div>
                        <div class="row mt-2"><div class="col-5">{{ __('Dealer Price') }}</div> <div class="col-1">:</div> <div class="col-6"
                                id="product_dealer_price"></div></div>
                        <div class="row mt-2"><div class="col-5">{{ __('Stock') }}</div> <div class="col-1">:</div> <div class="col-6" id="product_stock"></div></div>
                        <div class="row mt-2"><div class="col-5">{{ __('Low Stock') }}</div> <div class="col-1">:</div> <div class="col-6" id="product_low_stock"></div></div>
                        <div class="row mt-2"><div class="col-5">{{ __('Expire Date') }}</div> <div class="col-1">:</div> <div class="col-6" id="expire_date"></div></div>
                        <div class="row mt-2"><div class="col-5">{{ __('Manufacturer') }}</div> <div class="col-1">:</div> <div class="col-6"
                                id="product_manufacturer"></div></div>
                    </ul>

                    <div class="table-responsive mt-3">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('Batch') }}</th>
                                    <th>{{ __('Stock') }}</th>
                                    <th>{{ __('MRP') }}</th>
                                    <th>{{ __('Expire Date') }}</th>
                                </tr>
                            </thead>
                            <tbody id="stocks_table">
                                 {{-- Filled via jQuery --}}
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
