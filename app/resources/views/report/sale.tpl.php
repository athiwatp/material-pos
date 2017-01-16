{% extends:'templates.parent' %}

{% block:title %}Sales{% endblock %}

{% block:pageTitle %}Sales{% endblock %}

{% block:content %}

<div ng-controller="SaleReportCtrl" ng-init="loadSales()">
    <h1>{[{reportTitle}]}</h1>
    <div class="row">
        <div class="input-field col s6">
            <button class="btn waves-effect teal" ng-click="printReturn('printableArea')"><i class="mdi-action-print"></i> Print</button>
        </div>
        <div class="input-field col s6">
            <select ng-model="transaction_type" ng-change="transactionChange()">
                <option ng-value="all" selected>All transactions</option>
                <option ng-value="0">Cash</option>
                <option ng-value="1">Accounts</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <div class="input-field col s2">
				<input type="text" id="date" class="datepicker" ng-model="dateData.fromDate">
				<label for="date">From</label>
			</div>
            <div class="input-field col s2">
				<input type="text" id="date2" class="datepicker" ng-model="dateData.toDate">
				<label for="date2">To</label>
			</div>
            <div class="input-field col s4">
                <button class="btn waves-effect btn-primary" ng-click="saleDate()">Submit</button>
            </div>
        </div>
    </div>
    <div id="printableArea">
    <table class="responsive-table centered">
        <thead>
            <tr>
                <th>OR</th>
                <th>Customer</th>
                <th>User</th>
                <th>Total</th>     
            </tr>
        </thead>
        <tbody >
            <tr ng-repeat="s in sales | orderBy:'-sdate' | filter:{transaction_type:transaction_type}">
                <td><a href="" ng-click="viewSaleDetails(s.or_number)" class="pink-text">{[{s.or_number}]}</a></td>
                <td ng-bind="s.customer_name"></td>
                <td ng-bind="s.username"></td>
                <td ng-bind="s.sales_total | currency:''"></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>Total: <b>{[{getTotalSales() | currency:''}]}</b></td>
            </tr>
        </tbody>
    </table>
    </div>
        <!-- START Sales Summary Modal -->
    <div id="viewSalesSummaryModal" class="modal">
        <div class="modal-content">
            <h4>OR# {[{or_number}]}</h4>
            <p>{[{date}]}</p>
            <table class="responsive-table display">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Total</th>    
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="sd in saleData">
                        <td ng-bind="sd.product_name"></td>
                        <td ng-bind="sd.sale_quantity"></td>
                        <td ng-bind="sd.total_price | currency:''"></td>    
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td ng-bind="orTotal() | currency:''" class="pink-text"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <a class="modal-action modal-close waves-effect btn-flat">Close</a>
        </div>
    </div>     
    <!-- End Sales Summary Modal -->
</div>

{% endblock %}

{% block:scripts %} __PARENT__
<script type="text/javascript" src="assets/app/controllers/SaleReportController.js"></script>
<script>
$('.datepicker').pickadate({
  format: 'yyyy-mm-dd',
  close: 'Select'
})
</script>
{% endblock %}