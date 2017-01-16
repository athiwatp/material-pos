{% extends:'templates.parent' %}

{% block:title %}Dashboard{% endblock %}

{% block:pageTitle %}Dashboard{% endblock %}

{% block:pageCaption %}Dashboard caption here{% endblock %}

{% block:content %}

<div class="container">
    <div id="card-stats">
        <div class="row">
            <div class="col s12 m6 l3">
                <div class="card">
                    <div class="card-content blue white-text">
                        <p class="card-stats-title"><i class="mdi-action-shopping-cart"></i> Sales</p>
                        <h4 class="card-stats-number">{{$cash + $account}}</h4>
                        <p>Cash: {{$cash}} | Account: {{$account}}</p>
                        <br>
                    </div>
                    <div class="card-action blue darken-2">
                        <a href="/app/sales" class="white-text">NEW SALE <i class="mdi-navigation-chevron-right right"></i></a>
                    </div>
                </div>
            </div>            
            <div class="col s12 m6 l3">
                <div class="card">
                    <div class="card-content green white-text">
                        <p class="card-stats-title"><i class="mdi-social-group"></i> Customers</p>
                        <h4 class="card-stats-number">{{$active + $inactive}}</h4>
                        <p>Active: {{$active}} | Inactive: {{$inactive}}</p>
                    </div>
                    <div class="card-action green darken-2">
                        <a href="/app/customers" class="white-text">View All <i class="mdi-navigation-chevron-right right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col s12 m6 l3">
                <div class="card">
                    <div class="card-content pink lighten-1 white-text">
                        <p class="card-stats-title"><i class="mdi-action-shopping-cart"></i> Products</p>
                        <h4 class="card-stats-number">{{$products}}</h4>
                        <br>
                    </div>
                    <div class="card-action pink darken-2">
                        <a href="/app/products" class="white-text">View All <i class="mdi-navigation-chevron-right right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <span><center>Welcome, choose a common task below to get started!</center></span>
        <div class="container">
            <ul class="collapsible" data-collapsible="accordion">
                <li>
                    <div class="collapsible-header"><i class="mdi-content-content-copy left"></i>Sales Report</div>
                    <div class="collapsible-body">
                        <div class="container">
                            <p><a href="/app/reports/sales" class="waves-effect waves-light blue btn">Today's Sales Report</a></p>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="mdi-action-assignment-returned left"></i>Returns Report</div>
                    <div class="collapsible-body">
                    <div class="container">
                        <p><a href="/app/reports/returns-from-dealer" class="waves-effect waves-light blue btn">From Dealers</a>
                        <a href="/app/reports/returns-to-company" class="waves-effect waves-light blue btn">To Companies</a></p>
                    </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="mdi-action-shopping-cart left"></i>Item Summary Report</div>
                    <div class="collapsible-body">
                        <p>Lorem ipsum dolor sit amet.</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

    <!-- End View Customer Modal -->
    <!--SpeakJS--><div id="audio"></div>    


{% endblock %}

{% block:scripts %}
__PARENT__
    <script src="assets/js/plugins/speak-js/speakClient.js"></script>
{% endblock %}