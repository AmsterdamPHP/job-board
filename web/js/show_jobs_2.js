var JobRating = chic.Class.extend({
    init: function() {
        $('#jobRatingWrapper').bind('rated', this.rateJob);
    },
    rateJob: function(event, value) {
        console.log('rating the job! ' + value);

        $.ajax({
            type: "POST",
            url: '/job/2/rate',
            data: { rating: value},
            success: this.handleSuccessfulRating
        });
    },
    handleSuccessfulRating: function() {
        console.log('rated the job!');
    }
});