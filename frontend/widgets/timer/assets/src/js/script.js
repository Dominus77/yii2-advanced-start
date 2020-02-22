$(function () {
    function initCountDownTimer(prop, trans) {

        i18n.translator.add(trans);

        let note = $('#note_' + prop.id),
            countdownId = prop.id,
            timestamp = prop.timestamp,
            msg = prop.msg;

        $('#countdown_' + countdownId).countdown({
            timestamp: timestamp,
            callback: function (days, hours, minutes, seconds) {
                let message = msg;

                if ((new Date()).getTime() < timestamp) {
                    message = i18n("%n days", days) + ", ";
                    message += i18n("%n hours", hours) + ", ";
                    message += i18n("%n minutes", minutes) + " " + i18n("and") + " ";
                    message += i18n("%n seconds", seconds) + " <br />";
                }
                note.html(message);
            }
        });
    }

    window.initCountDownTimer = initCountDownTimer;
});
