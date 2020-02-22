$(function () {
    function initCountDownTimer(prop) {
        let note = $('#note_' + prop.id),
            countdownId = prop.id,
            timestamp = prop.timestamp,
            msg = prop.msg,
            complete = false;

        if ((new Date()).getTime() > timestamp) {
            complete = true;
        }

        console.log(timestamp);

        $('#countdown_' + countdownId).countdown({
            timestamp: timestamp,
            callback: function (days, hours, minutes, seconds) {
                let message = msg;

                if ((new Date()).getTime() < timestamp) {
                    message = days + " day" + (days === 1 ? '' : 's') + ", ";
                    message += hours + " hour" + (hours === 1 ? '' : 's') + ", ";
                    message += minutes + " minute" + (minutes === 1 ? '' : 's') + " and ";
                    message += seconds + " second" + (seconds === 1 ? '' : 's') + " <br />";
                }
                note.html(message);
            }
        });
    }

    window.initCountDownTimer = initCountDownTimer;
});
