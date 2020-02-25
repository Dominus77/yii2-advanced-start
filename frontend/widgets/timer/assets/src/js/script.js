$(function () {
    /**
     * Initialise jQuery Countdown Plugin
     * @url http://tutorialzine.com/2011/12/countdown-jquery/
     * @param prop array
     * @param trans array
     */
    function initCountDownTimer(prop, trans) {

        i18n.translator.add(trans);

        let noteContainer = $('#note_' + prop.id),
            countdownContainer = $('#countdown_' + prop.id),
            timestamp = prop.timestamp,
            message = prop.msg,
            currentDate = (new Date()).getTime();

        countdownContainer.countdown({
            timestamp: timestamp,
            callback: function (days, hours, minutes, seconds) {
                if (currentDate < timestamp) {
                    message = i18n("%n days", days) + ", ";
                    message += i18n("%n hours", hours) + ", ";
                    message += i18n("%n minutes", minutes) + " " + i18n("and") + " ";
                    message += i18n("%n seconds", seconds) + " <br />";
                }
                noteContainer.html(message);
            }
        });
    }

    window.initCountDownTimer = initCountDownTimer;
});
