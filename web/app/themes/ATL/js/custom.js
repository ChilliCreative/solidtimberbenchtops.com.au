// JavaScript Document

jQuery(document).ready(function($){

    //hide all inputs except the first one
    $('p.hide_this').not(':eq(0)').hide();

    //functionality for add-file link
    $('a.add_file').on('click', function(e){
      //show by click the first one from hidden inputs
      $('p.hide_this:not(:visible):first').show('slow');
      e.preventDefault();
    });

    //functionality for del-file link
    $('a.del_file').on('click', function(e){
      //var init
      var input_parent = $(this).parent();
      var input_wrap = input_parent.find('span');
      //reset field value
      input_wrap.html(input_wrap.html());
      //hide by click
      input_parent.hide('slow');
      e.preventDefault();
    });
  });