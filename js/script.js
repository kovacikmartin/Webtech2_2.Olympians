$(document).ready(function(){

    $('#winnersTable').DataTable({
        "searching": false,
        "paging": false,
        "info": false,
        "scrollY": "70%",
        "scrollCollapse": true,

        // when ordering by Type of OH, take into account Year also
        "columnDefs":[{
            "orderData": [5, 2],
            "targets": 5
        }]
    }).columns.adjust();

    $('#mostWinningTable').DataTable({
        "order": [],
        "searching": false,
        "paging": false,
        "info": false,
        "scrollY": "70%",
        "scrollCollapse": true
    }).columns.adjust();

    $('#personTable').DataTable({
        "order": [0, "asc"],
        "searching": false,
        "paging": false,
        "info": false,
        "scrollY": "70%",
        "scrollCollapse": true
    }).columns.adjust();
});