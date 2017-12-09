<?php include parts('modal_head'); ?>

    <form>
        <div class="form-group">
            <label for="name">Імя </label>
            <input id="name" class="form-control field">
        </div>

        <div class="form-group">
            <label for="description">Опис</label>
            <input id="description" class="form-control field">
        </div>

        <div class="form-group">
            <label for="code">Код <span title="Для вказання діапазону введіть наприклад: '1000-2304' БЕЗ ПРОБІЛІВ!" data-toggle="tooltip" class="hint">?</span></label>
            <input id="code" class="form-control field">
        </div>

        <div class="form-group">
            <label for="type_coupon">Тип</label>
            <select id="type_coupon" class="form-control field">
                <option selected value="" class="none"></option>
                <option value="0">Стаціонарний</option>
                <option value="1">Накопичувальний</option>
            </select>
        </div>

        <div id="for-form"></div>

        <div class="form-group">
            <button class="btn btn-primary" id="create">Створити</button>
        </div>
    </form>

<?php include parts('modal_foot'); ?>