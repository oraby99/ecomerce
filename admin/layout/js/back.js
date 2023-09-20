$(function()
{
    'use strict';
     $('[placeholder]').focus(function ()
     {
         $(this).attr('data-text',$(this).attr('placeholder'));
         $(this).attr('placeholder' ,'');
     }).blur(function ()
     {
        $(this).attr('placeholder',$(this).attr('data-text'));
     });
    // $('input').each(function()
    // {
    //     if($(this).attr('required') === 'required')
    //     {
    //         $(this).after("<span class='astrix'>*</span>");
    //     }
    // }
    // )
    var pass = $('.password');
    $('.show-pass').hover(function()
    {
       pass.attr('type' , 'text');
    }, function()
    {
        pass.attr('type' , 'password');
    });

   $('.confirm').click(function()
   {
     return confirm("ARE YOU SURE ?");
        
   });
   
//    $('h3').click(function()
//    {
//     $(this).next('.p').fadeToggle();
//    });
        // $('h3').click(function()
        // {
        //     $(this).next('.full').fadeToggle(200);
            
        // });

});