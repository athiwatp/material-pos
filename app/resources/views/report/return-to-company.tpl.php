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
                <th>Date</th>
                <th>TR Number</th>
                <th>Product</th>
                <th>User</th>
                <th>Quantity</th>
                
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="r in companyReturns | orderBy:'-phdate'">
                <td ng-bind="r.phdate | dateToISO | date:'medium'"></td>
                <td ng-bind="r.or_number"></td>
                <td ng-bind="r.product_name"></td>
                <td ng-bind="r.username"></td>
                <td ng-bind="r.quantity"></td> 
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Total: <b>{[{getTotalReturnsToCompany()}]}</b></td>
            </tr>
        </tbody>
    </table>
    </div>
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