{% extends:'templates.parent' %}

{% block:title %}Reports{% endblock %}

{% block:pageTitle %}Returns{% endblock %}

{% block:content %}

<div ng-controller="ReturnReportCtrl" ng-init="loadReturns()">
	<h1>{[{reportTitle}]}</h1>
	<button class="btn waves-effect teal" ng-click="printReturn('printableArea')"><i class="mdi-action-print"></i> Print</button>
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
			<div class="input-field col s6">
				<button class="btn waves-effect btn-primary" ng-click="returnDate()">Submit</button>
			</div>
		</div>
	</div>
	<div id="printableArea">
		<table class="responsive-table centered">
			<thead>
				<tr>
					<th>OR Number</th>
					<th>Product</th>
					<th>Quantity</th>
					<th>User</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="r in returns | orderBy:'-phdate'">
					<td><a href="" ng-click="viewSaleDetails(r.or_number)" class="pink-text">{[{r.or_number}]}</a></td>
					<td ng-bind="r.product_name"></td>
					<td ng-bind="r.quantity"></td>
					<td ng-bind="r.username"></td>
					<td ng-bind="r.phdate | dateToISO | date:'medium'"></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>Total: <b>{[{getTotalReturns()}]}</b></td>
				</tr>
			</tbody>
		</table>
	</div>
	<!-- START Sales Summary Modal -->
	<div id="viewSalesSummaryModal" class="modal">
		<div class="modal-content">
			<h4>OR# {[{or_number}]}</h4>
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
<script type="text/javascript" src="assets/app/controllers/ReturnReportController.js"></script>
<script>
$('.datepicker').pickadate({
  format: 'yyyy-mm-dd',
  close: 'Select'
})
</script>
{% endblock %}