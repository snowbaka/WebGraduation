setTimeout(function(){
    $('.show-notification').slideUp(2000);
}, 3000);

$('#dataTableList').DataTable({
    responsive: true,
    "language": {
        "emptyTable":     "No data exists",
        "lengthMenu":     "Show _MENU_ ",
        "search":         "Search",
        "paginate": {
            "next":       "Next",
            "previous":   "Previous"
        },
        "processing": "",
        "infoFiltered": " ",
        "infoEmpty":"No data exists",
        "zeroRecords": " ",

    },
});

$(".confirm__btn").click(function(event){
    event.preventDefault();
    let $this = $(this);

    $.confirm({
        title: 'Warning?',
        content: 'Are you sure you want to do this.',
        type: 'green',
        buttons: {
            ok: {
                text: "ok!",
                btnClass: 'btn-primary',
                keys: ['enter'],
                action: function(){
                    window.location = $this.attr('href');
                }
            },
            cancel: function(){
                console.log('the user clicked cancel');
            }
        }
    });
});

$(document).ready(function() {
    var url = window.location;
    var element = $('ul.sidebar-menu a').filter(function() {
        return this.href == url;
    }).parent().parent().parent().addClass('active').addClass('menu-open');

    var e = $('ul.sidebar-menu a').filter(function() {
        return this.href == url;
    }).parent().addClass('active').addClass('menu-open');

    $('.chosen-select').select2();
});