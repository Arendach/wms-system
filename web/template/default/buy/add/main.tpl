<!-- Navigation -->

<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#main">Основна інформація</a></li>
    <li><a data-toggle="tab" href="#products">Товари</a></li>
</ul>

<!-- Content -->

<div class="tab-content">

    <!-- Information -->

    <div id="main" class="tab-pane fade in active">
        <form class="form-horizontal" id="form_order" style="margin-top: 10px">
            <?php include t_file('buy/add/' . $type) ?>
        </form>
    </div>

    <!-- Products -->

    <div id="products" class="tab-pane fade">
        <?php include t_file('buy/add/products') ?>
        <div class="form-group">
            <div class="col-md-4">
                <button id="create" class="btn btn-primary">Зберегти</button>
            </div>
        </div>
    </div>

</div>