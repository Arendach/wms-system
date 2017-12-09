<div class="modal_head"><span id="modal_close">X</span></div>
<div id="modal_body">
    <form>
        <h2 class="centered">Заповнити інформацію</h2>
        <div class="form-group">
            <label for="type">Робочий/Вихідний</label>
            <select id="type" class="field form-control">
                <option value="1">Робочий</option>
                <option value="0">Вихідний</option>
            </select>
        </div>
        <div class="form-group">
            <label for="turn_up">Вихід на роботу</label>
            <input class="field form-control time" id="turn_up">
        </div>

        <div class="form-group">
            <label for="went_away">Повернення додому</label>
            <input class="field form-control time" id="went_away">
        </div>

        <div class="form-group">
            <label for="dinner_break">Обідня перерва </label>
            <input class="field form-control time" id="dinner_break">
        </div>

        <div class="form-group">
            <label for="work_day">Робочий день</label>
            <input class="field form-control time" id="work_day">

        </div>

        <div class="form-group">
            <button class="btn btn-primary" id="create" data-day="<?= $day ?>">Зберегти</button>
        </div>

    </form>
</div>
