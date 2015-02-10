$(function () {
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    $('#calendar-holder').fullCalendar({
        header: {
            left: 'prev, next',
            center: 'title',
            right: 'month, basicWeek, basicDay,'
        },
        defaultDate: '2014-12-03',
        selectable: false,
        selectHelper: true,
        select: function(start, end) {
            var title = prompt('Esemény neve:');
            var eventData;
            if (title) {
                eventData = {
                    title: title,
                    start: start,
                    end: end
                };
                $('#calendar-holder').fullCalendar('renderEvent', eventData, true); // stick? = true
            }
            jQuery('#calendar-holder').fullCalendar('unselect');
        },
        editable: false,
        eventLimit: true, // allow "more" link when too many events
        eventSources: [
            {
                url: Routing.generate('fullcalendar_loader'),
                type: 'POST',
                // A way to add custom filters to your event listeners
                data: {
                    //filter: 'my_custom_filter_param'
                },
                error: function() {
                    alert('There was an error while fetching Google Calendar!');
                }
            }
        ]
    });
});
