 // SideNav Initialization
 $(".button-collapse").sideNav();

 var container = document.querySelector('.custom-scrollbar');
 var ps = new PerfectScrollbar(container, {
   wheelSpeed: 2,
   wheelPropagation: true,
   minScrollbarLength: 20
 });

 // Data Picker Initialization
 $('.datepicker').pickadate();

 // Material Select Initialization
 $(document).ready(function () {
   $('.mdb-select').material_select();
 });

 // Tooltips Initialization
 $(function () {
   $('[data-toggle="tooltip"]').tooltip()
 })


