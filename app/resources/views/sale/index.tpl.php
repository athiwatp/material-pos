{% extends:'templates.parent' %}

{% block:title %}Sales{% endblock %}

{% block:pageTitle %}Sales{% endblock %}

{% block:content %}

<div ng-controller="SaleCtrl">
    <div class="row">
        <div class="col s12 l4">
            <div class="card-panel">
                <div class="row">
                    <div class="input-field col s9">
                        <i class="mdi-action-account-circle prefix"></i>
                        <input id="customer" placeholder="Customer Name" type="text" class="validate" disabled ng-model="saleData.customer_name">
                        <label for="customer">Customer</label>
                    </div>
                    <div class="input-field col s3">
                        <a href="" ng-click="selectCustomer()">Browse</a>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s9">
                        <i class="mdi-action-shopping-cart prefix"></i>
                        <input id="product" placeholder="Product Code" type="text" class="validate" disabled ng-model="saleData.product_code">
                        <label for="product">Product</label>
                    </div>
                    <div class="input-field col s3">
                        <a href="" ng-click="selectProduct()">Browse</a>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <i class="mdi-action-add-shopping-cart prefix"></i>
                        <input id="quantity" type="number" class="validate" ng-model="saleData.quantity">
                        <label for="quantity">Quantity</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <b>Product Price: {[{ saleData.price | currency:'₱' }]}</b>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <b>Amount: {[{ saleData.quantity * saleData.price | currency:'₱' }]}</b>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 pink-text">
                        <b>Total: {[{ saleData.totalAmount | currency:'₱' }]}</b>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <center><button class="btn blue" ng-click="addToCart()"><i class="mdi-action-add-shopping-cart"></i> Add To Cart</button></center>
                    </div>
                </div>
                <br><hr>
                <div class="row">
                    <div class="input-field col s4">
                            <input type="checkbox" class="filled-in" id="filled-in-box" ng-model="isCash"/>
                            <label for="filled-in-box"><b>Cash?</b></label>
                    </div>
                    <div class="input-field col s8">
                        <center><button class="btn pink" ng-confirm-click="Are you sure?" confirmed-click="printReturn('cartDiv')"><i class="mdi-action-print"></i> Print Invoice</button></center>
                    </div>
                </div>
                <br>
            </div>
        </div>
        <div class="col s12 l8">
            <div id="cartDiv">
            <table class="bordered responsive-table highlight display" id="cartTable" >
                <thead>
                    <tr>
                        <th>Qty</th>
                        <th>Description</th>
                        <th>Unit Price</th>
                        <th>Amount</th>
                        <th class="hideonPrint">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="inv in invoiceData">
                        <td ng-bind="inv.product_quantity"></td>
                        <td ng-bind="inv.product_name"></td>
                        <td ng-bind="inv.product_price | currency:''"></td>
                        <td ng-bind="inv.product_amount | currency:''"></td>
                        <td class="hideonPrint"><a href="" class="btn-flat red-text" ng-click="removeItem(inv)"><i class="mdi-navigation-close"></i></a></td>
                    </tr>
                     <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td id="totalAmountSale">Total: {[{saleData.totalAmount | currency:'₱'}]}</td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
    </div>
    <!-- Customer Modal -->
<div id="addCustomerModal" class="modal">
	<div class="modal-content">
		<table datatable="ng" dt-options="dtOptions" class="responsive-table highlight display" cellspacing="0">
			<thead>
				<tr>
					<th>Name</th>
					<th>Credit Limit</th>
                    <th>Select</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="c in customers">
					<td ng-bind="c.customer_name" ng-class="{'strike' : c.status == 0}"></td>
					<td ng-bind="c.customer_credit_limit | currency:'₱' "></td>
                    <td><button class="btn waves-effect" ng-click="addCustomer(c.customer_id)">Select</button></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
    <!-- End Customer Modal -->

    <!-- Product Modal -->
<div id="addProductModal" class="modal">
	<div class="modal-content">
        <table datatable="ng" dt-options="dtOptions" class="responsive-table display" cellspacing="0" id="productsTable">
            <thead>
                <tr>
                    <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Select</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="p in products" ng-class="{'qtyLess' : p.product_quantity <= 10}">
                    <td ng-bind="p.product_code"></td>
                    <td ng-bind="p.product_name"></td>
                    <td ng-bind="p.product_quantity"></td>
                    <td><button class="btn waves-effect" ng-click="addProduct(p.product_id)">Select</button></td>
                </tr>
            </tbody>
        </table>
	</div>
</div>
    <!-- End Product Modal -->
    <!--SpeakJS--><div id="audio"></div>
</div>

{% endblock %}

{% block:scripts %} __PARENT__
<script type="text/javascript" src="assets/app/controllers/SaleController.js"></script>
<script src="assets/js/plugins/speak-js/speakClient.js"></script>
<script>
$("#totalAmountSale").css("display", "none");
</script>
{% endblock %}