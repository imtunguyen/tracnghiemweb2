$(document).ready(function() {
    var $tabs = $('#t_draggable2')
    $("tbody.t_sortable").sortable({
      connectWith: ".t_sortable",
      items: "> tr:not(:first)",
      appendTo: $tabs,
      helper:"clone",
      zIndex: 999990
    }).disableSelection();
    
    var $tab_items = $(".nav-tabs > li", $tabs).droppable({
      accept: ".t_sortable tr",
      hoverClass: "ui-state-hover",
      drop: function( event, ui ) { return false; }
    });
  });