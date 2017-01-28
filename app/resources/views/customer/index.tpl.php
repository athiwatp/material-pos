{% extends:'templates.parent' %}

{% block:title %}Customers{% endblock %}

{% block:pageTitle %}Customers{% endblock %}

{% block:pageCaption %}View, Update and Search Customers{% endblock %}

{% block:content %}

<div ng-controller="CustomerCtrl" ng-init="loadCustomers()">
    <table datatable="ng" dt-options="dtOptions" class="responsive-table display" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Credit Limit</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="c in customers">
                <td ng-bind="c.customer_id"></td>
                <td ng-bind="c.customer_name" ng-class="{'strike' : c.status == 0}"></td>
                <td ng-bind="c.customer_credit_limit | currency:'₱' "></td>
                <td>
                    <button class="waves-effect waves-light btn blue darken-1" ng-click="openViewCustomerModal(c.customer_id, $index)">View</button>
                    <button class="waves-effect waves-light btn teal" ng-click="openSalesModal(c.customer_id)">Sales</button>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="fixed-action-btn">
        <a class="btn-floating btn-large waves-effect waves-light red" ng-click="openAddCustomerModal()"><i class="mdi-content-add"></i></a>
    </div>
    <!-- Add Customer Modal -->
    <div id="addCustomerModal" class="modal">
        <div class="modal-content">
            <h4>Add Customer</h4>
            <div class="row">
                <form action="" class="col s12">
                    <div class="input-field col s6">
                        <input id="full_name" type="text" class="validate" ng-model="customerData.full_name">
                        <label for="full_name">Full Name</label>
                    </div>
                    <div class="input-field col s6">
                        <input id="company" type="text" class="validate" ng-model="customerData.company">
                        <label for="company">Company</label>
                    </div>
                    <div class="input-field col s6">
                        <input id="address" type="text" class="validate" ng-model="customerData.address">
                        <label for="address">Address</label>
                    </div>
                    <div class="input-field col s6">
                        <input id="email" type="text" class="validate" ng-model="customerData.email">
                        <label for="email">Email</label>
                    </div>
                    <div class="input-field col s6">
                        <input id="contact" type="text" class="validate" ng-model="customerData.contact">
                        <label for="contact">Contact</label>
                    </div>
                    <div class="input-field col s6">
                        <input id="credit_limit" type="number" class="validate" ng-model="customerData.credit_limit">
                        <label for="credit_limit">Credit Limit</label>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <a class="waves-effect btn-flat teal lighten-2 white-text" ng-click="addCustomer()">Submit <i class="mdi-content-send right"></i></a>
            <a class="modal-action modal-close waves-effect btn-flat">Cancel</a>
        </div>
    </div>
    <!-- End Add Customer Modal -->
    <!-- View Customer Modal -->
    <div id="viewCustomerModal" class="modal">
        <div class="modal-content">
            <h4>Customer #{[{ucustomerData.customer_id}]}</h4>
            <div class="row">
                <form action="" class="col s12">
                <input type="hidden" ng-model="indexData">
                    <div class="input-field col s6">
                        <input placeholder="Full Name" id="full_name" type="text" class="validate" ng-model="ucustomerData.customer_name">
                        <label for="full_name">Full Name</label>
                    </div>
                    <div class="input-field col s6">
                        <input placeholder="Company" id="company" type="text" class="validate" ng-model="ucustomerData.customer_company">
                        <label for="company">Company</label>
                    </div>
                    <div class="input-field col s6">
                        <input placeholder="Address" id="address" type="text" class="validate" ng-model="ucustomerData.customer_address">
                        <label for="address">Address</label>
                    </div>
                    <div class="input-field col s6">
                        <input placeholder="Email" id="email" type="text" class="validate" ng-model="ucustomerData.customer_email">
                        <label for="email">Email</label>
                    </div>
                    <div class="input-field col s6">
                        <input placeholder="Contact" id="contact" type="text" class="validate" ng-model="ucustomerData.customer_contact">
                        <label for="contact">Contact</label>
                    </div>
                    <div class="input-field col s6">
                        <input placeholder="Credit Limit" id="credit_limit" type="number" class="validate" ng-model="ucustomerData.customer_credit_limit">
                        <label for="credit_limit">Credit Limit</label>
                    </div>
                    <div class="input-field col s12" ng-if="ucustomerData.status == 1">
                        <a ng-click="updateCustomerStatus(0, ucustomerData.customer_id)" class="waves-effect waves-light btn pink darken-1"><i class="mdi-navigation-close left"></i> Deactivate</a>
                    </div>
                    <div class="input-field col s12" ng-if="ucustomerData.status == 0">
                        <a ng-click="updateCustomerStatus(1, ucustomerData.customer_id)" class="waves-effect waves-light btn green darken-1"><i class="mdi-navigation-check left"></i> Activate</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <a class="waves-effect btn-flat teal white-text" ng-click="updateCustomer(ucustomerData.customer_id)">Update <i class="mdi-content-send right"></i></a>
            <a class="modal-action modal-close waves-effect btn-flat">Cancel</a>
        </div>
    </div>
    <!-- End View Customer Modal -->
    <!-- View Sales Modal -->
    <div id="viewSalesModal" class="modal bottom-sheet">
        <div class="modal-content">
            <h4>Sales of Customer #{[{customerId}]}</h4>
            <table datatable="ng" dt-options="dtOptions" class="responsive-table display" cellspacing="0">
                <thead>
                    <tr>
                        <th>OR</th>
                        <th>Total</th>
                        <th>Date</th>    
                        <th>Payment</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="s in sales">
                        <td><a href="" ng-click="viewSaleDetails(s.or_number, s.created_at)" class="pink-text">{[{s.or_number}]}</a></td>
                        <td><a href="" ng-click="viewPaymentHistory(s.or_number)" class="blue-text text-darken-2">{[{s.sales_total | currency:''}]}</a></td>
                        <td ng-bind="s.created_at | date:'medium'"></td>
                        <td><button class="btn" ng-click="selectOR(s.or_number, s.sales_id)">Pay now</button></td>
                    </tr>
                </tbody>
            </table>
            
        </div>
        <div class="modal-footer">
            <a class="modal-action modal-close waves-effect btn-flat">Close</a>
        </div>
    </div>
    <!-- End Sales Modal -->   
    <!-- START Sales Summary Modal -->
    <div id="viewSalesSummaryModal" class="modal">
        <div class="modal-content">
            <h4>Summary of OR# {[{or_number}]}</h4>
            <a href="" ng-click="reprint(or_number, 'reprintArea')">Reprint Receipt</a>
            <div id="reprintArea">
            <table class="responsive-table display">
                <thead>
                    <tr>
                        <th>Quantity</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Total</th>    
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="sd in saleData">
                        <td ng-bind="sd.sale_quantity"></td>
                        <td ng-bind="sd.product_name"></td>
                        <td ng-bind="sd.current_price | currency:''"></td>
                        <td ng-bind="sd.total_price | currency:''"></td>    
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Total: <b>{[{totalAmount()| currency:''}]}</b></td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
        <div class="modal-footer">
            <a class="modal-action modal-close waves-effect btn-flat">Close</a>
        </div>
    </div>     
    <!-- End Sales Summary Modal -->
    <!-- Start payment modal -->
    <div id="paymentModal" class="modal">
        <div class="modal-content">
            <h4>Payment for OR# {[{paymentOR_number}]}</h4>
            <div class="row">
                <div class="input-field col s12">
					<input id="Amount" type="text" class="validate" ng-model="paymentData.amount">
					<label for="Amount">Amount</label>
				</div>
                <div class="input-field col s12">
					<input id="PaymentFor" type="text" class="validate" ng-model="paymentData.notes">
					<label for="PaymentFor">as Payment for</label>
				</div>
            </div>
        </div>
        <div class="modal-footer">
            <a class="waves-effect btn-flat teal white-text" ng-click="payOR(sales_id)">Pay <i class="mdi-content-send right"></i></a>
            <a class="modal-action modal-close waves-effect btn-flat">Cancel</a>
        </div>
    </div>   
    <!-- End Payment Modal -->
    <!-- START Payment History Modal -->
    <div id="viewPaymentHistoryModal" class="modal">
        <div class="modal-content">
            <h4>Payment History of OR# {[{payment_or_number}]}</h4>
            <table class="responsive-table display">
                <thead>
                    <tr>
                        <th>Date</th> 
                        <th>User</th>
                        <th>Notes</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="phd in paymentHistoryData | orderBy:'-created_at'">
                        <td ng-bind="phd.sdate"></td> 
                        <td ng-bind="phd.username"></td>
                        <td ng-bind="phd.notes"></td>
                        <td ng-bind="phd.payment_amount | currency:''"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td ng-bind="paymentTotal() | currency:''"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <a class="modal-action modal-close waves-effect btn-flat">Close</a>
        </div>
    </div>     
    <!-- End Payment History Modal -->    
    <!--SpeakJS--><div id="audio"></div>    
</div>

{% endblock %}

{% block:scripts %}
__PARENT__
    <script type="text/javascript" src="assets/app/controllers/CustomerController.js"></script>
    <script src="assets/js/plugins/speak-js/speakClient.js"></script>
{% endblock %}