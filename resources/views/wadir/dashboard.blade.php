@extends('_layout.admin.app')

@section('custom-css')

<link rel="stylesheet" href="{{ url('assets/admin/vendor/fullcalendar/fullcalendar.min.css') }}" />

<style>

#calendar {
    width: auto;
    margin: 0 auto;
}

.response {
    height: 60px;
}

.success {
    background: #cdf3cd;
    padding: 10px 60px;
    border: #c3e6c3 1px solid;
    display: inline-block;
}
</style>
@endsection

@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-6">
        <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>
    </div> 
</div>

<div class="row">
    {{-- <div class="col-md-5">
        <div class="card shadow mb-4">
            <div class="card-body">
                <h3>Kalender Proker</h3>
                <div class="response"></div>
                <div id='calendar'></div>
            </div>
        </div>
    </div> --}}
    <div class="col-md-12">
        <div class="row mb-4">
            <div class="col-md-6">
                <h5>Daftar Kegiatan</h5>
                <span class="text-muted">Kegiatan Bulan <b>{{ $this_month_text }}</b></span>
            </div>
            {{-- <div class="col-md-6 text-right">
                <a href="{{ url('wadir/kegiatan') }}" class="btn btn-outline-primary">Lihat Semua</a>
            </div> --}}
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <form class="form-inline" method="GET" action="{{ url('wadir/dashboard/search_kegiatan') }}">
                    <div class="input-group mb-2 mr-sm-2">
                        <select name="ormawa_id" id="ormawa_id" class="form-control">
                            <option value="">- Semua Ormawa -</option>
                            
                            @foreach ($ormawa as $value)
                                <option {{ ($ormawa_id == $value->id_ormawa) ? 'selected' : "" }} value="{{ $value->id_ormawa }}">{{ $value->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary mb-2">Cari</button>
                </form>
            </div>
        </div>

        @foreach ($kegiatan as $value)
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{ empty($value->poster) ? 'https://via.placeholder.com/300x300.png?text=Belum+tersedia' : url('uploads/' . $value->poster) }}" width="300" class="img-fluid">
                        </div>
                        <div class="col-md-8">
                            <h5 class="card-title mb-1">{{ $value->nama }}</h5>
                            <span class="badge badge-primary">{{ $value->nama_ormawa }}</span>

                            <p class="pt-3">{{ $value->tanggal }} | {{ date('H:i', strtotime($value->waktu_mulai)) }} - {{ date('H:i', strtotime($value->waktu_akhir)) }}</p>

                            <div class="pt-0">
                                <a href="{{ url('wadir/kegiatan/detail/' . $value->id_kegiatan) }}" class="card-link">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
</div>
@endsection

@section('custom-js')
<script src="{{ url('assets/admin/vendor/fullcalendar/lib/jquery.min.js') }}"></script>
<script src="{{ url('assets/admin/vendor/fullcalendar/lib/moment.min.js') }}"></script>
<script src="{{ url('assets/admin/vendor/fullcalendar/fullcalendar.min.js') }}"></script>
<script>
    var URL = '<?= url('/') ?>';

    $(document).ready(function () {
        var calendar = $('#calendar').fullCalendar({
            editable: true,
            events: URL + '/wadir/dashboard/calender/get_data',
            displayEventTime: false,
            eventRender: function (event, element, view) {
                element.find('.fc-title').append('<div class="hr-line-solid-no-margin"></div><span style="font-size: 10px">' + event.description + '</span></div>');
                if (event.allDay === 'true') {
                    event.allDay = true;
                } else {
                    event.allDay = false;
                }
            },
            selectable: true,
            selectHelper: true,
            // select: function (start, end, allDay) {
            //     var title = prompt('Event Title:');
    
            //     if (title) {
            //         var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
            //         var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
    
            //         $.ajax({
            //             url: 'add-event.php',
            //             data: 'title=' + title + '&start=' + start + '&end=' + end,
            //             type: "POST",
            //             success: function (data) {
            //                 displayMessage("Added Successfully");
            //             }
            //         });
            //         calendar.fullCalendar('renderEvent',
            //                 {
            //                     title: title,
            //                     start: start,
            //                     end: end,
            //                     allDay: allDay
            //                 },
            //         true
            //                 );
            //     }
            //     calendar.fullCalendar('unselect');
            // },
            
            // editable: true,
            // eventDrop: function (event, delta) {
            //             var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
            //             var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
            //             $.ajax({
            //                 url: 'edit-event.php',
            //                 data: 'title=' + event.title + '&start=' + start + '&end=' + end + '&id=' + event.id,
            //                 type: "POST",
            //                 success: function (response) {
            //                     displayMessage("Updated Successfully");
            //                 }
            //             });
            //         },
            // eventClick: function (event) {
            //     var deleteMsg = confirm("Do you really want to delete?");
            //     if (deleteMsg) {
            //         $.ajax({
            //             type: "POST",
            //             url: "delete-event.php",
            //             data: "&id=" + event.id,
            //             success: function (response) {
            //                 if(parseInt(response) > 0) {
            //                     $('#calendar').fullCalendar('removeEvents', event.id);
            //                     displayMessage("Deleted Successfully");
            //                 }
            //             }
            //         });
            //     }
            // }
    
        });
    });
    
    function displayMessage(message) {
            $(".response").html("<div class='success'>"+message+"</div>");
        setInterval(function() { $(".success").fadeOut(); }, 1000);
    }
    </script>
@endsection