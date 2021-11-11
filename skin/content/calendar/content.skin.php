<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.$content_skin_url.'/style.css">', 0);

$cal_result = sql_query("select cal_add, cal_color from {$g5['cal_table']} order by cal_id asc");

$cal_data = array();
for($i=0; $row = sql_fetch_array($cal_result); $i++) { 
    // $cal[$i]['add'] = $row['cal_add'];
    // $cal[$i]['color'] = $row['cal_color'];
   array_push($cal_data,array("googleCalendarId" => trim($row['cal_add']), "color" =>$row['cal_color']));
}


?>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js'></script>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js'></script>
    <script src="<?php echo G5_PLUGIN_URL?>/fullcalendar/main.js"></script>
    <script src='<?php echo G5_PLUGIN_URL?>/fullcalendar/gcal.js'></script>

<script>

function formatAMPM(date) {
  var hours = date.getHours();
  var minutes = date.getMinutes();
  var ampm = hours >= 12 ? 'pm' : 'am';
  hours = hours % 12;
  hours = hours ? hours : 12; // the hour '0' should be '12'
  minutes = minutes < 10 ? '0'+minutes : minutes;
  var strTime = hours + ':' + minutes + ' ' + ampm;
  return strTime;
}

function leadingZeros(n, digits) {
  var zero = '';
  n = n.toString();

  if (n.length < digits) {
    for (i = 0; i < digits - n.length; i++)
      zero += '0';
  }
  return zero + n;
}

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar_list');

    var calendar = new FullCalendar.Calendar(calendarEl, {
            googleCalendarApiKey : 'AIzaSyDcnW6WejpTOCffshGDDb4neIrXVUA1EAE',
            height:'auto',
      headerToolbar: {
        left: '',
        center: 'title',
        right: ''
      },
      titleFormat: function(date) {
	return `이번주 일정`;
},
      titleRangeSeparator:" ~ ",
      eventDidMount: function(info) {
            document.getElementById("cal-title").innerHTML =info.event.title;
            if(info.event.extendedProps.description){
                document.getElementById("cal-desc").innerHTML =String(info.event.extendedProps.description).replace(/\n/gi,"<br>");
                document.getElementById("cal-desc").style.paddingTop="5px"
            }
            else{
                document.getElementById("cal-desc").style.paddingTop="0"
                document.getElementById("cal-desc").innerHTML="";
            }
            document.getElementById("cal-date").innerHTML = "";
            const template = document.getElementById('template');
         
                tippy(info.el, {
                  theme: 'custom',
                  allowHTML: true,
                  animation: 'shift-away',
                  content: template.innerHTML
                });
              },
             eventDataTransform: function(event) {
               event.url = "";
               return event;
             },
      initialView: 'listWeek',
      initialDate: new Date(),
      navLinks: false, // can click day/week names to navigate views
      editable: true,
      dayMaxEvents: true, // allow "more" link when too many events
      eventSources : <? echo urldecode(json_encode($cal_data));?>
    });

    calendar.render();
  });
      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {

         headerToolbar: {
                 left: 'prev',
                 center: 'title',
                 right: 'next'
               },
            googleCalendarApiKey : 'AIzaSyDcnW6WejpTOCffshGDDb4neIrXVUA1EAE',
            initialView: 'dayGridMonth',
            fixedWeekCount: false,
            showNonCurrentDates:false,

            eventSources : <? echo urldecode(json_encode($cal_data));?>,
              eventTimeFormat: { // like '14:30:00'
                hour: 'numeric',
                minute: '2-digit',
                meridiem: 'short', 
                omitZeroMinute: true,
              },
            eventDidMount: function(info) {
            document.getElementById("cal-title").innerHTML =info.event.title;
            if(info.event.extendedProps.description){
                          document.getElementById("cal-desc").innerHTML =String(info.event.extendedProps.description).replace(/\n/gi,"<br>");
                document.getElementById("cal-desc").style.paddingTop="5px"

            }
            else{
                document.getElementById("cal-desc").style.paddingTop="0"
              document.getElementById("cal-desc").innerHTML="";
            }

          
            document.getElementById("cal-date").innerHTML =formatAMPM(info.event.start) + ' - ' +  formatAMPM(info.event.end) ;
            const template = document.getElementById('template');
         
                tippy(info.el, {
                  theme: 'custom',
                  allowHTML: true,
                  animation: 'shift-away',
                  content: template.innerHTML
                });
              },
              eventDataTransform: function(event) {
               event.url = "";
               return event;
             },

    });
        calendar.render();
      });
</script>
<?
include_once("_common.php"); //이걸 페이지 최상단에 호출합니다
?>

<?
    if(!$member[mb_id]){
    alert("회원만 열람 가능한 페이지입니다.");
  }
?>

<script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script>
<script src="https://unpkg.com/tippy.js@6"></script>

<div id="template" style="display: none; ">
    <div style="padding: 10px; ">
        <div id="cal-title"></div>
        <div id="cal-date"></div>
        <div id="cal-desc"></div>
    </div>
</div>


<?php echo $str; ?>