(function($) {
    "use strict";

    $(window).on('load', function() {
        $(".audioPlayer")
            .toArray()
            .forEach(function(player) {
                /**find the audio tag */

                var audio = $(player).find("audio")[0];
                var seekbarInner = $(player).find(".seekBar .inner");
                var seekbarOuter = $(player).find(".seekBar .outer");
                var volumeControl = $(player).find(".volumeControl .wrapper");
                var length;
                var interval;
                var seekBarPercentage;
                var volumePercentage;
                var minutes = parseInt(audio.duration / 60, 10);
                var seconds = parseInt(audio.duration % 60);

                /** set the end duration **/
                $(player).find(".timing .end").text(minutes + ":" + seconds);

                /**************************** All Functions  ************************/

                /**Find Percentage */
                var getPercentage = function(presentTime, totalLength) {
                    var calcPercentage = (presentTime / totalLength) * 100;
                    return parseFloat(calcPercentage.toString());
                };
                /**
                 *  Update seekBars
                 * */
                var updateSeekBar = function() {
                    seekBarPercentage = getPercentage(
                        audio.currentTime.toFixed(2),
                        length.toFixed(2)
                    );

                    /**update the seek bar percentage */
                    $(seekbarInner).css("width", seekBarPercentage + "%");

                    /**update the start time **/
                    $(player)
                        .find(".timing .start")
                        .text(parseInt(audio.currentTime / 60, 10) + ':' + parseInt(audio.currentTime % 60));
                };

                /************************ on click of button playing the song *************************/
                $(player)
                    .find(".btn")
                    .on("click", function() {
                        var _button = $(this);
                        /**if the button has class play then */
                        if (_button.hasClass("play")) {
                            _button.removeClass("play").addClass("pause");

                            /**find length of audio */
                            length = audio.duration;

                            /**** play the audio ****/
                            audio.play();

                            /**set seekbar percentage */
                            interval = setInterval(function() {


                                /**run this function to update seekbar */
                                if (!audio.paused) {
                                    /*check wheather audio is playing then*/
                                    updateSeekBar();
                                }

                                /**if audio playback ended */
                                if (audio.ended) {
                                    clearInterval(interval);
                                    $(player)
                                        .find(".albumArt");
                                    _button.removeClass("pause").addClass("play");
                                    seekbarInner.width(100 + "%");

                                    $(player)
                                        .find(".timing .start")
                                        .text('0:00');
                                }
                            }, 1000);
                        } else if (_button.hasClass("pause")) {
                            _button.removeClass("pause").addClass("play");
                            audio.pause();
                        }

                        /**animating album art */
                        $(player).find(".albumArt")
                    });

                /****************for click on scroll bar **************************/
                seekbarOuter.on("click", function(e) {
                    if (!audio.ended && length !== undefined) {
                        var seekPosition = e.pageX - $(seekbarOuter).offset().left;
                        if (seekPosition >= 0) {
                            audio.currentTime = (seekPosition * audio.duration) / $(seekbarOuter).width();
                            updateSeekBar();
                        }
                    }
                });

                /**************** for click on volume control ******************/
                volumeControl.find(".outer").on("click", function(e) {
                    var volumePosition = e.pageX - $(this).offset().left;
                    var audioVolume = volumePosition / $(this).width();
                    if (audioVolume >= 0 && audioVolume <= 1) {
                        audio.volume = audioVolume;
                        $(this)
                            .find(".inner")
                            .css("width", audioVolume * 100 + "%");
                    }
                });



                /**
                 * update volumeBar
                 **/
                var updateVolume = function() {
                    volumePercentage = getPercentage(audio.volume, 1);
                    $(volumeControl)
                        .find(".inner")
                        .css("width", volumePercentage + "%");
                };

                /**forEach End**/
            });

    });
})(jQuery);