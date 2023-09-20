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
        $('h1 span').click(function()
        {
            $(this).addClass('active').siblings().removeClass('active');
            $('.loginpage form').hide();
            $('.'+$(this).data('class')).show();
        });
      
        $('.livename').keyup(function()
        {
            $('.itembox .caption h3').text($(this).val());
        });
        $('.livedesc').keyup(function()
        {
            $('.itembox .caption p').text($(this).val());
        });
        $('.liveprice').keyup(function()
        {
            $('.itembox span').text($(this).val()  +'$' );
        });
});