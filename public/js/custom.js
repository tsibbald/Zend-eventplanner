/* JS */


/* Navigation */

$(document).ready(function(){

  $(window).resize(function()
  {
    if($(window).width() >= 765){
      $(".sidebar #nav").slideDown(350);
    }
    else{
      $(".sidebar #nav").slideUp(350); 
    }
  });


  $("#nav > li > a").on('click',function(e){
      if($(this).parent().hasClass("has_sub")) {
        e.preventDefault();
      }   

      if(!$(this).hasClass("subdrop")) {
        // hide any open menus and remove all other classes
        $("#nav li ul").slideUp(350);
        $("#nav li a").removeClass("subdrop");
        
        // open our new menu and add the open class
        $(this).next("ul").slideDown(350);
        $(this).addClass("subdrop");
      }
      
      else if($(this).hasClass("subdrop")) {
        $(this).removeClass("subdrop");
        $(this).next("ul").slideUp(350);
      } 
      
  });
});

$(document).ready(function(){
  $(".sidebar-dropdown a").on('click',function(e){
      e.preventDefault();

      if(!$(this).hasClass("open")) {
        // hide any open menus and remove all other classes
        $(".sidebar #nav").slideUp(350);
        $(".sidebar-dropdown a").removeClass("open");
        
        // open our new menu and add the open class
        $(".sidebar #nav").slideDown(350);
        $(this).addClass("open");
      }
      
      else if($(this).hasClass("open")) {
        $(this).removeClass("open");
        $(".sidebar #nav").slideUp(350);
      }
  });

});

/* Widget close */
$(function() {
$('.wclose').click(function(e){
  e.preventDefault();
  var $wbox = $(this).parent().parent().parent();
  $wbox.hide(100);
});
});
/* Widget minimize */
$(function() {
  $('.wminimize').click(function(e){
    e.preventDefault();
    var $wcontent = $(this).parent().parent().next('.widget-content');
    if($wcontent.is(':visible')) 
    {
      $(this).children('i').removeClass('icon-chevron-up');
      $(this).children('i').addClass('icon-chevron-down');
    }
    else 
    {
      $(this).children('i').removeClass('icon-chevron-down');
      $(this).children('i').addClass('icon-chevron-up');
    }            
    $wcontent.toggle(500);
  }); 
  });
/* Calendar */


/* Progressbar animation */

    setTimeout(function(){

        $('.progress-animated .progress-bar').each(function() {
            var me = $(this);
            var perc = me.attr("data-percentage");

            //TODO: left and right text handling

            var current_perc = 0;

            var progress = setInterval(function() {
                if (current_perc>=perc) {
                    clearInterval(progress);
                } else {
                    current_perc +=1;
                    me.css('width', (current_perc)+'%');
                }

                me.text((current_perc)+'%');

            }, 600);

        });

    },600);

/* Slider */

   

/* Support */

$(document).ready(function(){
  $("#slist a").click(function(e){
     e.preventDefault();
     $(this).next('p').toggle(200);
  });
});

/* Scroll to Top */


  $(".totop").hide();

  $(function(){
    $(window).scroll(function(){
      if ($(this).scrollTop()>300)
      {
        $('.totop').slideDown();
      } 
      else
      {
        $('.totop').slideUp();
      }
    });

    $('.totop a').click(function (e) {
      e.preventDefault();
      $('body,html').animate({scrollTop: 0}, 500);
    });

  });

/* jQuery Notification */




$(document).ready(function() {

  $('.noty-alert').click(function (e) {
      e.preventDefault();
      noty({text: 'Some notifications goes here...',layout:'topRight',type:'alert',timeout:2000});
  });

  $('.noty-success').click(function (e) {
      e.preventDefault();
      noty({text: 'Some notifications goes here...',layout:'top',type:'success',timeout:2000});
  });

  $('.noty-error').click(function (e) {
      e.preventDefault();
      noty({text: 'Some notifications goes here...',layout:'topRight',type:'error',timeout:2000});
  });

  $('.noty-warning').click(function (e) {
      e.preventDefault();
      noty({text: 'Some notifications goes here...',layout:'bottom',type:'warning',timeout:2000});
  });

  $('.noty-information').click(function (e) {
      e.preventDefault();
      noty({text: 'Some notifications goes here...',layout:'topRight',type:'information',timeout:2000});
  });

});

//Profielpagina, friendrequest functies

$(document).ready(function() {
 $('#randomInsert').submit(function() {
        var url = $(this).attr('action');
        var data = $(this).serialize();
        $('#table').empty(); 
        $('#table').append('<tr><th>User Id</th><th>Username</th><th>Emailaddress</th><th>Group Role</th><th>Status</th><th>Delete</th><tr>'); 
        $.post(url, data ,function(o) {
            for (var i = 0; i < o.length; i++)
            {
                $('#table').append(
                  '<tr>' +  
                  '<td>' + o[i].user_id + '</td>' + 
                  '<td>' + o[i].username + '</td>' + 
                  '<td>' + o[i].email + '</td>' + 
                  '<td>' + o[i].group_role + '</td>' + 
                  '<td><button class="btn btn-xs btn-success"><i class="icon-ok"></i></button></td><td><button class="btn btn-xs btn-danger"><i class="icon-remove"></i> </button></td></tr>'
                  );
            }
        }, 'json');
        return false;
    });
});

$(document).ready(function() {
        var url = $(this).attr('action');
        var data = $(this).serialize();
        $('#friendstable').empty(); 
        $('#friendstable').append('<tr><th>User Id</th><th>Username</th><th>Emailaddress</th><th>Group Role</th><tr>'); 
        $.post(url, data ,function(o) {
            for (var i = 0; i < o.length; i++)
            {
                $('#friendstable').append(
                  '<tr>' +  
                  '<td>' + o[i].user_id + '</td>' + 
                  '<td>' + o[i].username + '</td>' + 
                  '<td>' + o[i].email + '</td>' + 
                  '<td>' + o[i].group_role + '</td>' + 
                  '<td><button class="btn btn-xs btn-success"><i class="icon-ok"></i> </button><button class="btn btn-xs btn-warning"><i class="icon-pencil"></i> </button><button class="btn btn-xs btn-danger"><i class="icon-remove"></i> </button></td></tr>'
                  );
            }
        }, 'json');
        return false;

});

//Eventdetail pagina

$(document).ready(function() {
 $('#evdetailSearch').submit(function() {
        var url = $(this).attr('action');
        var data = $(this).serialize();
        console.log(data);
        $('.boxa').empty(); 
        $.post(url, data ,function(o) {
            for (var i = 0; i < o.length; i++)
            {
                $('.boxa').append(
                  '<option value='+o[i].user_id +'>' +  
                    o[i].user_id + 
                    o[i].username +  
                    ', ' + o[i].email +  
                  '</option>'
                  );
            }
        }, 'json');
        return false;
    });
});

$(function() {
      var btn = $('#confirm').click(function () {

        var optionValues = [];
        var eventid = $('#eventid').val();
        
        $('#select2 option').each(function() {
            optionValues.push({id: $(this).val()});
            
        });
     

        $.ajax({
          type: "POST",
          url: '/calender/inject/'+ eventid,
          data: {optionValues:optionValues},
        });
                
      });
});

$(function() {
    $('#add').click(function () {
      return !$('#select1 option:selected').remove().appendTo('#select2');
    });
    $('#remove').click(function () {

        var optionValues = [];
        var eventid = $('#eventid').val();
        $('#select2 option:selected').each(function() {
            optionValues.push({id: $(this).val()});
        });
        console.log(optionValues);
        
        $.ajax({
          type: "POST",
          url: '/calender/delete/'+ eventid,
          data: {optionValues:optionValues},
        }); 
        return !$('#select2 option:selected').remove().appendTo('#select1');

    });
});

$(function() {
  $.ajax({
    url: '/user/panel',
    dataType : 'json',
    success: function(result){
      $.each(result, function(i, v) {
        $('#friends').append(v.fid); 
      });
    }
  });
});

$(function() {
      $('#email').click(function () {

        var optionValues = [];
        var eventid = $('#eventid').val();
        $('#select2 option:selected').each(function() {
            optionValues.push({
              email: $(this).html(),
              eventid: $('#eventid').html(),
              start: $('#start').html(),
              title: $('#title').html(),
              end: $('#end').html(),
              owner: $('#owner').html(),
              });
        });
        
        $.ajax({
          type: "POST",
          url: '/calender/email/'+ eventid,
          data: {optionValues:optionValues},
        });    
      });
});
// Switchbutton (attending event) op de evdetail.phtml pagina
$(function() {
  $('.make-switch').on('switch-change', function (e, data) {
    var attendingstatus = data.value;
    var eventid = $('#eventid').val();
    $.ajax({
      type: "POST",
      url: '/calender/attending/'+ eventid,
      data: {attendingstatus:attendingstatus},
    }); 
  });
});

$(function() {
  var eventid = $('#eventid').val();
  $.ajax({
    url: "/calender/attending/" + eventid,
    dataType: "json",
    success: function(data) {
      if(data.attending == 'true'){
        $('.switch-animate').addClass('switch-on').removeClass('switch-off');
      }
      else
      {
        $('.switch-animate').addClass('switch-off').removeClass('switch-on');
      }
    },
  });
});


$(function() {
  var eventid = $('#delete').val();
  $('#delete').click(function () {
    $.ajax({
      type: "POST",
      url: "/calender/delevent/" + eventid,
      dataType: "json",
      success: function(data) 
      {
        window.location.href = "/calender";
      },
    });
  });
});

$(function() {
  $('#SaveXml').click(function () {
  var rpc_array = [];
  var rpc_username = $('#rpc_username').val();
  var rpc_pass = $('#rpc_pass').val();
  var rpc_link = $('#rpc_link').val();
  rpc_array.push(rpc_username);
  rpc_array.push(rpc_pass);
  rpc_array.push(rpc_link);
    $.ajax({
      type: "POST",
      url: "/user/savexml",
      data: {rpc_array:rpc_array },
      success: function(data) 
      {
        //window.location.href = "/user/admin";
      },
    });
  });
});


$(function() {
  $('.deleteuser').click(function () {
    var userarr = [];
    var val = $(this).val();
    userarr.push(val);
      $.ajax({
      type: "POST",
      url: "/user/deleteuser",
      data: {userarr:userarr},
      success: function(data) 
      {
        //window.location.href = "/user/admin";
      },
    });
  });
});


$(function() {
  if ($("#calendar")){
  // do something here
  var date = new Date();
  var d = date.getDate();
  var m = date.getMonth();
  var y = date.getFullYear();
  $.getJSON( "/calender/events", function(data) {
    var events = data;
    var calendar = $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
      },
      editable: true,
      allDayDefault: false,
      timeFormat: 'H(:mm)',
      axisFormat: 'H(:mm)',
      events: events,
      droppable: true, 
      selectable: true,
      selectHelper: true,
      select: function(start, end, allDay) {
        var tijd = $.fullCalendar.formatDate( start, "yyyy/MM/dd" );
        $("#id_eventstart").val(tijd + ' 11:00:00');
        $("#id_eventend").val('End time');
        $('<div class="modal-backdrop fade in"></div>').appendTo(document.body);
        $( "#myModal" ).fadeIn( 30, function() {
          $("body").click
          (
            function(event)
            {
              if($(event.target).is('#myModal') || $(event.target).is('.sluit'))
              {
                $("#myModal").hide();
                $('.modal-backdrop').remove();
                $('#eventForm').trigger("reset");
              }
            }
            );
        });
      },
      eventClick: function(calEvent, jsEvent, view) {
        window.location = "/calender/evdetail/" + calEvent.id;
      },
    });
});
}
});

$(function() {
  $("#eventForm").submit(function(event){
    event.preventDefault();
    var myEvent = $(this).serializeArray();
    var unformatted_date = myEvent[2].value;
    var formatted_date = dateConvertor(unformatted_date);
    myEvent[2].value = formatted_date;
        $.ajax({
          type: 'POST',
          url: '/calender/add',
          data: myEvent,
        }).done(function(data) { 
          location.reload();
        });
      });

});

// Event Creation Modal
function timeConverter(UNIX_timestamp){
 var a = new Date(UNIX_timestamp);
 console.log(a);
     var year = a.getFullYear();
     var month = ("0" + (a.getMonth() + 1)).slice(-2);
     var day = ("0" + a.getDate()).slice(-2);
     var hour = a.getHours();
     var sec = ("0" + (a.getSeconds())).slice(-2);
     var min = ("0" + (a.getMinutes())).slice(-2);
     var time = year+'-'+month+'-'+day+' '+hour+':'+min+':'+sec;
     return time;
 }

$(function() {
$( ".duration" ).change(function(event) {
  var value = $("#id_eventstart").val();
  var d = new Date(value);
  var date = d.getTime();
  var add =  $(this).val() * 3600 * 1000;
  var result = date + add;
  var time = timeConverter(result);
  $("#id_eventend").val(time);
});
});

$(function() { 
      $('.datetimepicker').datetimepicker({format:'Y/m/d H:i:s', startDate: '-1990/01/02'});
      $('.datepicker').datetimepicker({format:'Y-m-d H:i:s', startDate: '-1990/01/02'});
      $( ".pw-field" ).click(function() {
        var value = $( this ).attr('value');
        $(this).text(value);
      });
    });

/* Date convertor for addevent */
function dateConvertor(date){
 var a = new Date(date);
     var year = a.getFullYear();
     var month = ("0" + (a.getMonth() + 1)).slice(-2);
     var day = ("0" + a.getDate()).slice(-2);
     var hour = a.getHours();
     var sec = ("0" + (a.getSeconds())).slice(-2);
     var min = ("0" + (a.getMinutes())).slice(-2);
     var time = year+'-'+month+'-'+day+' '+hour+':'+min+':'+sec;
     return time;
 }

// Color events

$(function() {
$.getJSON( "/calender/events", function(data) {
 for (var i = 0; i < data.length; i++)
            {
                if(data[i].color=='#ff5d5e')
                {
                   $('#_invited').append(
                    '<tr><td><a href="/calender/evdetail/'+data[i].id+'">'+data[i].title+'</a></td><td>'+ data[i].start + '</td><td>' + data[i].end + '</td></tr>'  
                  );

                }
                else
                {
                $('#_created').append(
                    '<tr><td><a href="/calender/evdetail/'+data[i].id+'">'+data[i].title+'</a></td><td>'+ data[i].start + '</td><td>' + data[i].end + '</td></tr>'  
                  );
                }
            }

}, 'json');
});

// Type ahead search

$(function() {
  $('#typeahead').typeahead({
    source: function (query, process) {
      return $.ajax({
        type: "POST",
        url: '/social/typeahead',
        data:  'query=' + query,
        dataType: 'JSON',
      }).done(function(data) {
        process(data);
      });
    },
  })
});



  
