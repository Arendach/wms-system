<div class="modal_head"><span id="modal_close">X</span></div>
<div id="modal_body">
    <form>
        <h2 class="centered">Привязка замовлення</h2>
        <table class="table table-bordered">
            <tr>
                <td>#</td>
                <td>Імя</td>
                <td>Телефон</td>
                <td>Дата</td>
                <td rowspan="2" class="vertical-centered">
                    <button id="search" class="btn btn-primary">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </td>
            </tr>
            <tr>
                <td><input class="search form-control" name="id"></td>
                <td><input class="search form-control" name="name"></td>
                <td><input class="search form-control" name="phone"></td>
                <td><input class="search form-control" type="date" name="date"></td>
            </tr>
        </table>

        <div id="place_search"></div>
        <button id="save" style="margin-top: 10px; display: none;" class="btn btn-success">Зберегти</button>
    </form>
</div>