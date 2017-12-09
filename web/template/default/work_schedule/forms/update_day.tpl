<div class="modal_head"><span id="modal_close">X</span></div>
<div id="modal_body">
    <form>
        <h2 class="centered">Оновлення інформації</h2>
        <div class="form-group">
            <label for="type">Робочий/Вихідний</label>
            <select id="type" class="field form-control">
                <option <?= $type == 1 ? 'selected' : ''; ?> value="1">Робочий</option>
                <option <?= $type == 0 ? 'selected' : ''; ?> value="0">Вихідний</option>
            </select>
        </div>
        <div class="form-group">
            <label for="turn_up">Вихід на роботу</label>
            <input class="field form-control" id="turn_up" value="<?= $turn_up; ?>">
        </div>

        <div class="form-group">
            <label for="went_away">Повернення додому</label>
            <input class="field form-control" id="went_away" value="<?= $went_away; ?>">
        </div>

        <div class="form-group">
            <label for="work_day">Робочий день</label>
            <input class="field form-control" id="work_day" value="<?= $work_day; ?>">
        </div>

        <div class="form-group">
            <label for="dinner_break">Обідня перерва </label>
            <input class="field form-control" id="dinner_break" value="<?= $dinner_break; ?>">
        </div>

        <div class="form-group">
            <button class="btn btn-primary" data-type="day" data-id="<?= $id ?>" id="update">Зберегти</button>
        </div>

    </form>
</div>
