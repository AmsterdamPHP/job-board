var JobRating = chic.Class.extend({
    isRated: false,

    init: function() {
        $('#jobRatingWrapper').bind('rated', this.rateJob);
    },
    rateJob: function(event, value) {
        if (this.isRated)
            return;

        this.isRated = true;

        var ri = $(this);
        var jobId = ri.data('jobid')

        ri.rateit('readonly', true);

        $.ajax({
            type: "POST",
            url: '/job/'+jobId+'/rate',
            data: { rating: value},
            cache: false
        }).done(function(data) {
                $.cookie.json = true;

            var ratedJobs = $.cookie('ratedJobs');
            if ( ! $.isArray(ratedJobs))
            {
                ratedJobs = [];
            }

            ratedJobs.push(data);

            $.cookie('ratedJobs', ratedJobs, { path: '/' });
            console.log($.cookie('ratedJobs'));
        });
    }
});