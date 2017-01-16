{% extends:'templates.parent' %} 
{% block:title %}Products{% endblock %} 
{% block:styles %}
<style>
	.qtyLess {
  		color: #E51C23;
	}
</style>
{% endblock %}
{% block:pageTitle %}Products{% endblock %} {% block:pageCaption
%}View, Update and Search Products{% endblock %} {% block:content %}
<div ng-controller="ProductCtrl" ng-init="loadProducts()">
	<table datatable="ng" dt-options="dtOptions" class="responsive-table display" cellspacing="0" id="productsTable">
		<thead>
			<tr>
				<th>Product Code</th>
				<th>Product Name</th>
				<th>Quantity</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="p in products" ng-class="{'qtyLess' : p.product_quantity <= 10}">
				<td ng-bind="p.product_code"></td>
				<td ng-bind="p.product_name"></td>
				<td ng-bind="p.product_quantity"></td>
				<td>
					<button class="btn btn-info btn-raised" ng-click="openViewProductModal(p.product_id, $index)">View</button>
					<button class="btn btn-info btn-raised teal" ng-click="addQuantityModal(p.product_id, $index)"><i class="mdi-action-add-shopping-cart"></i> Add</button>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="fixed-action-btn">
		<a class="btn-floating btn-large waves-effect waves-light red" ng-click="openAddProductModal()"><i class="mdi-content-add"></i></a>
	</div>
	<!-- Add Product Modal -->
	<div id="addProductModal" class="modal">
		<div class="modal-content">
			<h4>Add Product</h4>
			<div class="row">
				<form action="" class="col s12">
					<div class="input-field col s6">
						<input placeholder="Code" id="code" type="text" class="validate" ng-model="productData.product_code">
						<label for="code">Product Code</label>
					</div>
					<div class="input-field col s6">
						<input placeholder="Name" id="name" type="text" class="validate" ng-model="productData.product_name">
						<label for="name">Product Name</label>
					</div>
                    <div class="input-field col s6">
						<input placeholder="Price" id="price" type="text" class="validate" ng-model="productData.product_price">
						<label for="price">Product Price</label>
					</div>
				</form>
			</div>
		</div>
		<div class="modal-footer">
			<a class="waves-effect btn-flat teal lighten-2 white-text" ng-click="addProduct()">Submit <i class="mdi-content-send right"></i></a>
			<a class="modal-action modal-close waves-effect btn-flat">Cancel</a>
		</div>
	</div>
	<!-- End View Product Modal -->
<!-- View Product Modal -->
<div id="viewProductModal" class="modal">
	<div class="modal-content">
		<h4>Product #{[{uproductData.product_id}]}</h4>
		<div class="row">
			<form action="" class="col s12">
			<input type="hidden" ng-model="indexData">
				<div class="input-field col s6">
					<input placeholder="Code" id="code" type="text" class="validate" ng-model="uproductData.product_code">
					<label for="code">Product Code</label>
				</div>
				<div class="input-field col s6">
					<input placeholder="Name" id="name" type="text" class="validate" ng-model="uproductData.product_name">
					<label for="name">Product Name</label>
				</div>
				<div class="input-field col s6">
					<input placeholder="Price" id="price" type="text" class="validate" ng-model="uproductData.product_price">
					<label for="price">Product Price</label>
				</div>
				<div class="input-field col s6">
						<input disabled placeholder="Quantity" id="qty" type="number" class="validate" ng-model="uproductData.product_quantity">
						<label for="qty">Product Quantity</label>
				</div>
				<div class="input-field col s12">
						<input type="checkbox" class="filled-in" id="filled-in-box" ng-model="isReturnToCompany"/>
      					<label for="filled-in-box"><b>RETURN TO COMPANY</b></label>
				</div>
				<br>
				<div ng-show="isReturnToCompany">
					<div class="input-field col s2">
							<input id="qty" type="number" class="validate" ng-model="returnToCompanyData.qty">
							<label for="qty">Quantity</label>
					</div>
					<div class="input-field col s2">
							<input id="or" type="text" class="validate" ng-model="returnToCompanyData.or_number">
							<label for="or">TR Number</label>
					</div>
					<div class="input-field col s6">
							<a class="waves-effect btn-flat pink darken-1 white-text" ng-click="returnToCompany(uproductData.product_id, indexData)">OK</a>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="modal-footer">
		<a class="waves-effect btn-flat teal white-text" ng-click="updateProduct(uproductData.product_id, $index)">Update <i class="mdi-content-send right"></i></a>
		<a class="modal-action modal-close waves-effect btn-flat">Cancel</a>
	</div>
</div>
<!-- End View Product Modal -->
<!-- Add Quantity Modal -->
  <div id="addQtyModal" class="modal">
    <div class="modal-content">
	  <h4>Add Items to #{[{productQty.product_code}]}</h4>
      <div class="row">
			<form action="" class="col s12">
				<div class="container">
				<p ng-class="{'qtyLess' : productQty.product_quantity <= 10}">Current Quantity: <b>{[{productQty.product_quantity}]}</b></p>
				<br>
				</div>
				<div class="input-field col s12">
					<input placeholder="Quantity" id="qty" type="number" class="validate" ng-model="addItemData.qty">
					<label for="qty">Quantity</label>
				</div>
				<div class="input-field col s4">
					<input type="checkbox" class="filled-in" id="isReturn" ng-model="isReturn"/>
      				<label for="isReturn"><b>RETURN</b></label>
				</div>
				<div class="input-field col s8" ng-show="isReturn">
					<input id="or_number" type="text" class="validate" ng-model="addItemData.or_number">
					<label for="or_number">OR NUMBER</label>
				</div>
		 </form>
		</div>
    </div>
	
    <div class="modal-footer">
	   <a class="modal-action modal-close waves-effect btn-flat">Cancel</a>
      <a ng-click="addQty(productQty.product_id, index)" class="waves-effect teal white-text btn-flat">Add</a>
    </div>
  </div>
<!-- End Add Quantity Modal -->
</div>
{% endblock %} 

{% block:scripts %} __PARENT__
<script type="text/javascript" src="assets/app/controllers/ProductController.js"></script>
<script src="assets/js/plugins/speak-js/speakClient.js"></script>
{% endblock %}